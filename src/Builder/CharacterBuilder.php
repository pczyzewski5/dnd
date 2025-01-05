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
use App\Character\Skills;
use App\Dto\CharacterConfigDto;
use App\Dto\LevelConfigDto;
use App\Dto\RaceConfigDto;
use App\Entity\Level;
use App\Entity\Origin;
use App\Entity\Race;
use App\Enum\AlignmentEnum;
use App\Repository\LevelRepository;
use App\Repository\OriginRepository;
use App\Repository\RaceRepository;
use App\Service\RaceService;

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
        private readonly SavingThrowsBuilder $savingThrowsBuilder,
        private readonly PassiveInsightCalculator $passiveInsightCalculator,
        private readonly PassivePerceptionCalculator $passivePerceptionCalculator,
        private readonly ArmorClassCalculator $armorClassCalculator,
        private readonly SpeedCalculator $speedCalculator,
        private readonly InitiativeCalculator $initiativeCalculator,
        private readonly LevelRepository $levelRepository,
        private readonly ProficiencyBonusCalculator $proficiencyBonusCalculator,
        private readonly HitDiceCalculator $hitDiceCalculator,
        private readonly SimpleLevelsCalculator $simpleLevelsCalculator,
        private readonly SkillsBuilder $skillsBuilder,
    ) {
    }

    public function build(CharacterConfigDto $config): Character
    {
        $origin = $this->getOrigin($config);
        $race = $this->getRace($config);
        $raceConfig = $this->getRaceConfig($race);
        $levels = $this->getLevels($config);
        $abilities = $this->getAbilities($config, $raceConfig);
        $proficiencies = $this->getProficiencies($config, $levels, $origin);
        $skills = $this->getSkills($config, $abilities, $race, $levels);
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
            $skills,
            $this->getAbilitySkills($abilities, $proficiencies, $proficiencyBonus),
            $this->getSavingThrows($abilities, $proficiencyBonus, $proficiencies),
            $this->getPassivePerception($abilities, $proficiencyBonus, $proficiencies),
            $this->getPassiveInsights($abilities, $proficiencyBonus, $proficiencies),
            $this->getArmorClass($abilities, $skills),
            $this->getSpeed($raceConfig, $skills),
            $this->getLanguages($config, $raceConfig),
            $raceConfig->darkvision,
            $this->getAlignment($config),
            $this->getInitiative($abilities, $skills),
            $this->getAttackCount($skills),
        // spellcasting do implementacji
        );
    }

    private function getAttackCount(Skills $skills): int
    {
        $count = 1;

        if ($skills->hasSkill('bonus attack')) {
            $count++;
        }

        return $count;
    }

    private function getSkills(
        CharacterConfigDto $config,
        Abilities $abilities,
        Race $race,
        array $levels
    ): Skills {
        return $this->skillsBuilder
            ->setCharacterConfigDto($config)
            ->setAbilities($abilities)
            ->setLevels($levels)
            ->setRace($race)
            ->build();
    }

    private function getLanguages(
        CharacterConfigDto $characterConfig,
        RaceConfigDto $raceConfig
    ): array {
        $result = $raceConfig->languages;

        foreach ($characterConfig->levelConfigs as $levelConfig) {
            foreach ($levelConfig->languages as $language) {
                $result[] = $language->name;
            }
        }

        return $result;
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

    private function getRace(CharacterConfigDto $config): Race
    {
        return $this->raceRepository->getOneByName($config->race);
    }

    private function getRaceConfig(Race $race): RaceConfigDto
    {
        return $this->raceService->getRaceConfig($race);
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
        return $this->armorClassCalculator->calculate(
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
        Skills $skills
    ): int {
        return $this->initiativeCalculator->calculate($abilities, $skills);
    }
}