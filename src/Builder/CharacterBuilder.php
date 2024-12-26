<?php

declare(strict_types=1);

namespace App\Builder;

use App\Ability\NewAbilities;
use App\Calculator\HitPointsCalculator;
use App\Dto\CharacterConfigDto;
use App\Enum\NewAlignmentEnum;
use App\Level\NewLevels;
use App\NewCharacter\NewCharacter;
use App\Race\RaceConfig;
use App\Repository\RaceRepository;
use App\Service\RaceService;
use App\Service\SkillFinalizerService;

use function count;
use function var_dump;

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
    ) {
    }

    public function build(CharacterConfigDto $config): NewCharacter
    {
        $raceConfig = $this->getRaceConfig($config);
        $levels = $this->getLevels($config);
        $abilities = $this->getAbilities($config, $raceConfig);

        return new NewCharacter(
            $config->characterName,
            $config->playerName,
            $config->campaignName,
            $levels->hitDices,
            $this->getHitPoints($abilities, $levels),
            $abilities,
            $levels->simpleLevels,
            $this->getFinalizedSkills($abilities, $levels),
            $this->getAbilitySkills($abilities, $levels),
            $config->origin,
            $config->race,
            $this->getAlignment($config),  // do testów!!!
            $levels->proficiencies->getArmorProficiencies(),
            $levels->proficiencies->getWeaponProficiencies(),
            $levels->proficiencies->getToolProficiencies(),
            $levels->proficiencies->getSavingThrowProficiencies(),
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
    ): NewAbilities {
        $abilitiesBuilder = $this->abilitiesBuilder
            ->add(...$characterConfigDto->abilityConfigDtos)
            ->add(...$raceConfig->asi);

        foreach ($characterConfigDto->levelConfigDtos as $dto) {
            $abilitiesBuilder->add(...$dto->asi);
        }

        return $abilitiesBuilder->build();
    }

    private function getLevels(CharacterConfigDto $config): NewLevels
    {
        return $this->levelsBuilder
            ->setLevelConfigDtos($config->levelConfigDtos)
            ->build();
    }

    private function getFinalizedSkills(
        NewAbilities $abilities,
        NewLevels $levels
    ): array {
        return $this->skillFinalizerService->finalizeArray(
            $abilities,
            $levels->skills,
            count($levels->levels),
        );
    }

    private function getHitPoints(
        NewAbilities $abilities,
        NewLevels $levels
    ): int {
        return $this->hitPointsCalculator->newCalculate(
            $levels,
            $abilities->con->modifier
        );
    }

    private function getAbilitySkills(
        NewAbilities $abilities,
        NewLevels $levels,
    ): array {
        return $this->abilitySkillsBuilder
            ->setAbilities($abilities)
            ->setProficiencies($levels->proficiencies)
            ->setProficiencyBonus($levels->proficiencyBonus)
            ->build();
    }

    private function getAlignment(CharacterConfigDto $config): string
    {
        return NewAlignmentEnum::tryFrom($config->alignment)->value;
    }
}