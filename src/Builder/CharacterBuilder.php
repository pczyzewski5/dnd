<?php

declare(strict_types=1);

namespace App\Builder;

use App\Calculator\ArmorClassCalculator;
use App\Calculator\HitPointsCalculator;
use App\Calculator\InitiativeCalculator;
use App\Calculator\PassiveInsightCalculator;
use App\Calculator\PassivePerceptionCalculator;
use App\Calculator\SpeedCalculator;
use App\Character\Abilities;
use App\Character\Character;
use App\Character\Levels;
use App\Dto\CharacterConfigDto;
use App\Enum\AlignmentEnum;
use App\Race\RaceConfig;
use App\Repository\RaceRepository;
use App\Service\RaceService;
use App\Service\SkillFinalizerService;

use function count;

class CharacterBuilder
{
    public function __construct(
        private readonly RaceRepository $raceRepository,
        private readonly RaceService $raceService,
        private readonly AbilitiesBuilder $abilitiesBuilder,
        private readonly AbilitySkillsBuilder $abilitySkillsBuilder,
        private readonly HitPointsCalculator $hitPointsCalculator,
        private readonly LevelsBuilder $levelsBuilder,
        private readonly SkillFinalizerService $skillFinalizerService,
        private readonly SavingThrowsBuilder $savingThrowsBuilder,
        private readonly PassiveInsightCalculator $passiveInsightCalculator,
        private readonly PassivePerceptionCalculator $passivePerceptionCalculator,
        private readonly ArmorClassCalculator $armorClassCalculator,
        private readonly SpeedCalculator $speedCalculator,
        private readonly InitiativeCalculator $initiativeCalculator,
    ) {
    }

    public function build(CharacterConfigDto $config): Character
    {
        $raceConfig = $this->getRaceConfig($config);
        $levels = $this->getLevels($config);
        $abilities = $this->getAbilities($config, $raceConfig);

        return new Character(
            $abilities,
            $config->characterName,
            $config->playerName,
            $config->campaignName,
            $config->origin,
            $config->race,
            $levels->proficiencies,
            $levels->hitDices,
            $levels->simpleLevels,
            $levels->proficiencyBonus,
            $this->getHitPoints($abilities, $levels),
            $this->getFinalizedSkills($abilities, $levels),
            $this->getAbilitySkills($abilities, $levels),
            $this->getSavingThrows($abilities, $levels),
            $this->getPassivePerception($abilities, $levels),
            $this->getPassiveInsights($abilities, $levels),
            $this->getArmorClass($abilities, $levels),
            $this->getSpeed($raceConfig, $levels),
            $raceConfig->languages,
            $raceConfig->darkvision,
            $this->getAlignment($config),  // do testów!!!
            $this->getInitiative($abilities)
        );
    }

    private function getRaceConfig(CharacterConfigDto $config): RaceConfig
    {
        return $this->raceService->getRaceConfig(
            $this->raceRepository->findOneBy(['name' => $config->race])
        );
    }

    private function getAbilities(
        CharacterConfigDto $characterConfigDto,
        RaceConfig $raceConfig
    ): Abilities {
        $abilitiesBuilder = $this->abilitiesBuilder
            ->add(...$characterConfigDto->abilityConfigDtos)
            ->add(...$raceConfig->asi);

        foreach ($characterConfigDto->levelConfigDtos as $dto) {
            $abilitiesBuilder->add(...$dto->asi);
        }

        return $abilitiesBuilder->build();
    }

    private function getLevels(CharacterConfigDto $config): Levels
    {
        return $this->levelsBuilder
            ->setLevelConfigDtos($config->levelConfigDtos)
            ->build();
    }

    private function getFinalizedSkills(
        Abilities $abilities,
        Levels $levels
    ): array {
        return $this->skillFinalizerService->finalizeArray(
            $abilities,
            $levels->skills,
            count($levels->levels),
        );
    }

    private function getHitPoints(
        Abilities $abilities,
        Levels $levels
    ): int {
        return $this->hitPointsCalculator->calculate(
            $levels,
            $abilities->con->modifier
        );
    }

    private function getAbilitySkills(
        Abilities $abilities,
        Levels $levels,
    ): array {
        return $this->abilitySkillsBuilder
            ->setAbilities($abilities)
            ->setProficiencies($levels->proficiencies)
            ->setProficiencyBonus($levels->proficiencyBonus)
            ->build();
    }

    private function getAlignment(CharacterConfigDto $config): string
    {
        return AlignmentEnum::tryFrom($config->alignment)->value;
    }

    private function getSavingThrows(
        Abilities $abilities,
        Levels $levels
    ): array {
        return $this->savingThrowsBuilder
            ->setAbilities($abilities)
            ->setProficiencies($levels->proficiencies)
            ->setProficiencyBonus($levels->proficiencyBonus)
            ->build();
    }

    public function getPassivePerception(
        Abilities $abilities,
        Levels $levels
    ): int {
        return $this->passivePerceptionCalculator->newCalculate(
            $abilities,
            $levels->proficiencies,
            $levels->proficiencyBonus
        );
    }

    public function getPassiveInsights(
        Abilities $abilities,
        Levels $levels
    ): int {
        return $this->passiveInsightCalculator->newCalculate(
            $abilities,
            $levels->proficiencies,
            $levels->proficiencyBonus
        );
    }

    public function getArmorClass(
        Abilities $abilities,
        Levels $levels
    ): int {
        return $this->armorClassCalculator->newCalculate(
            $abilities,
            $levels->skills
        );
    }

    public function getSpeed(
        RaceConfig $raceConfig,
        Levels $levels
    ): int {
        return $this->speedCalculator->calculate(
            $raceConfig,
            $levels->skills
        );
    }

    public function getInitiative(
        Abilities $abilities,
    ): int {
        return $this->initiativeCalculator->calculate($abilities);
    }
}