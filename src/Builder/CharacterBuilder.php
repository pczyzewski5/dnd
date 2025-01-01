<?php

declare(strict_types=1);

namespace App\Builder;

use App\Calculator\ArmorClassCalculator;
use App\Calculator\HitDiceCalculator;
use App\Calculator\HitPointsCalculator;
use App\Calculator\InitiativeCalculator;
use App\Calculator\PassiveInsightCalculator;
use App\Calculator\PassivePerceptionCalculator;
use App\Calculator\ProficiencyBonusCalculator;
use App\Calculator\SimpleLevelsCalculator;
use App\Calculator\SpeedCalculator;
use App\Character\Abilities;
use App\Character\Character;
use App\Character\Proficiencies;
use App\Character\SkillFactory;
use App\Character\Skills;
use App\Dto\CharacterConfigDto;
use App\Dto\LevelConfigDto;
use App\Dto\RaceConfigDto;
use App\Entity\Level;
use App\Entity\Origin;
use App\Enum\AlignmentEnum;
use App\Repository\LevelRepository;
use App\Repository\OriginRepository;
use App\Repository\RaceRepository;
use App\Repository\SkillRepository;
use App\Service\RaceService;
use App\Service\SkillFinalizerService;

use function array_map;
use function array_merge;
use function count;

class CharacterBuilder
{
    public function __construct(
        private readonly ProficienciesBuilder $proficienciesBuilder,
        private readonly OriginRepository $originRepository,
        private readonly RaceRepository $raceRepository,
        private readonly RaceService $raceService,
        private readonly AbilitiesBuilder $abilitiesBuilder,
        private readonly AbilitySkillsBuilder $abilitySkillsBuilder,
        private readonly HitPointsCalculator $hitPointsCalculator,
        private readonly SkillFinalizerService $skillFinalizerService,
        private readonly SavingThrowsBuilder $savingThrowsBuilder,
        private readonly PassiveInsightCalculator $passiveInsightCalculator,
        private readonly PassivePerceptionCalculator $passivePerceptionCalculator,
        private readonly ArmorClassCalculator $armorClassCalculator,
        private readonly SpeedCalculator $speedCalculator,
        private readonly InitiativeCalculator $initiativeCalculator,
        private readonly LevelRepository $levelRepository,
        private readonly SkillRepository $skillRepository,
        private readonly ProficiencyBonusCalculator $proficiencyBonusCalculator,
        private readonly HitDiceCalculator $hitDiceCalculator,
        private readonly SimpleLevelsCalculator $simpleLevelsCalculator,
    ) {
    }

    public function build(CharacterConfigDto $config): Character
    {
        $origin = $this->getOrigin($config);
        $raceConfig = $this->getRaceConfig($config);
        $levels = $this->getLevels($config);
        $abilities = $this->getAbilities($config, $raceConfig);
        $proficiencies = $this->getProficiencies($config, $levels, $origin);
        $skills = $this->getSkills($config, $levels);
        $proficiencyBonus = $this->proficiencyBonusCalculator->calculate(count($levels));
        $hitDices = $this->hitDiceCalculator->calculate($levels);
        $simpleLevels = $this->simpleLevelsCalculator->calculate($levels);

        return new Character(
            $abilities,
            $config->characterName,
            $config->playerName,
            $config->campaignName,
            $config->origin,
            $config->race,
            $proficiencies,
            $hitDices,
            $simpleLevels,
            $proficiencyBonus,
            $this->getHitPoints($abilities, $levels),
            $this->getFinalizedSkills($abilities, $skills, $levels),
            $this->getAbilitySkills($abilities, $proficiencies, $proficiencyBonus),
            $this->getSavingThrows($abilities, $proficiencyBonus, $proficiencies),
            $this->getPassivePerception($abilities, $proficiencyBonus, $proficiencies),
            $this->getPassiveInsights($abilities, $proficiencyBonus, $proficiencies),
            $this->getArmorClass($abilities, $skills),
            $this->getSpeed($raceConfig, $skills),
            $raceConfig->languages,
            $raceConfig->darkvision,
            $this->getAlignment($config),
            $this->getInitiative($abilities)
        );
    }

    private function getOrigin(CharacterConfigDto $config): Origin
    {
        return $this->originRepository->getOneByName($config->origin);
    }

    private function getProficiencies(
        CharacterConfigDto $config,
        array $levels,
        Origin $origin,
    ): Proficiencies {
        return $this->proficienciesBuilder
            ->setLevels($levels)
            ->setOrigin($origin)
            ->setLevelConfigs($config->levelConfigs)
            ->build();
    }

    private function getRaceConfig(CharacterConfigDto $config): RaceConfigDto
    {
        return $this->raceService->getRaceConfig(
            $this->raceRepository->findOneBy(['name' => $config->race])
        );
    }

    private function getLevels(CharacterConfigDto $config): array
    {
        return array_map(
            fn (LevelConfigDto $dto): Level => $this->levelRepository
                ->getByLevelAndCharacterClass(
                    $dto->level,
                    $dto->class
                ),
            $config->levelConfigs
        );
    }

    private function getSkills(
        CharacterConfigDto $config,
        array $levels,
    ): Skills {
        $skills = [];

        foreach ($levels as $level) {
            $skills = array_merge(
                SkillFactory::createManyFromEntity(
                    $level->getSkills()->toArray()
                ),
                $skills
            );
        }

        foreach ($config->levelConfigs as $dto) {
            $skills = array_merge(
                SkillFactory::createManyFromEntity(
                    $this->skillRepository->getByNames($dto->skills)
                ),
                $skills
            );
        }

        return new Skills(...$skills);
    }

    private function getAbilities(
        CharacterConfigDto $characterConfigDto,
        RaceConfigDto $raceConfigDto
    ): Abilities {
        $abilitiesBuilder = $this->abilitiesBuilder
            ->addMany($characterConfigDto->abilityConfigs)
            ->addMany($raceConfigDto->asi);

        foreach ($characterConfigDto->levelConfigs as $dto) {
            $abilitiesBuilder->addMany($dto->asi);
        }

        return $abilitiesBuilder->build();
    }

    private function getFinalizedSkills(
        Abilities $abilities,
        Skills $skills,
        array $levels
    ): array {
        return $this->skillFinalizerService->finalizeArray(
            $abilities,
            $skills,
            count($levels),
        );
    }

    private function getHitPoints(
        Abilities $abilities,
        array $levels
    ): int {
        return $this->hitPointsCalculator->calculate(
            $levels,
            $abilities->con->modifier
        );
    }

    private function getAbilitySkills(
        Abilities $abilities,
        Proficiencies $proficiencies,
        int $proficiencyBonus
    ): array {
        return $this->abilitySkillsBuilder
            ->setAbilities($abilities)
            ->setProficiencies($proficiencies)
            ->setProficiencyBonus($proficiencyBonus)
            ->build();
    }

    private function getAlignment(CharacterConfigDto $config): string
    {
        return AlignmentEnum::tryFrom($config->alignment)->value;
    }

    private function getSavingThrows(
        Abilities $abilities,
        int $proficiencyBonus,
        Proficiencies $proficiencies
    ): array {
        return $this->savingThrowsBuilder
            ->setAbilities($abilities)
            ->setProficiencies($proficiencies)
            ->setProficiencyBonus($proficiencyBonus)
            ->build();
    }

    public function getPassivePerception(
        Abilities $abilities,
        int $proficiencyBonus,
        Proficiencies $proficiencies
    ): int {
        return $this->passivePerceptionCalculator->newCalculate(
            $abilities,
            $proficiencies,
            $proficiencyBonus
        );
    }

    public function getPassiveInsights(
        Abilities $abilities,
        int $proficiencyBonus,
        Proficiencies $proficiencies
    ): int {
        return $this->passiveInsightCalculator->newCalculate(
            $abilities,
            $proficiencies,
            $proficiencyBonus
        );
    }

    public function getArmorClass(
        Abilities $abilities,
        Skills $skills
    ): int {
        return $this->armorClassCalculator->newCalculate(
            $abilities,
            $skills
        );
    }

    public function getSpeed(
        RaceConfigDto $raceConfig,
        Skills $skills
    ): int {
        return $this->speedCalculator->calculate(
            $raceConfig,
            $skills
        );
    }

    public function getInitiative(
        Abilities $abilities,
    ): int {
        return $this->initiativeCalculator->calculate($abilities);
    }
}