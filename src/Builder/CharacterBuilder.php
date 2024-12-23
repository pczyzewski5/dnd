<?php

declare(strict_types=1);

namespace App\Builder;

use App\Ability\NewAbilities;
use App\Ability\NewAbilityFactory;
use App\Calculator\HitDiceCalculator;
use App\Calculator\HitPointsCalculator;
use App\Calculator\LevelsCalculator;
use App\Dto\AbilitiesConfigDto;
use App\Dto\CharacterConfigDto;
use App\Dto\LevelConfigDto;
use App\Entity\Level;
use App\Enum\NewAbilityEnum;
use App\NewCharacter\NewCharacter;
use App\Repository\LevelRepository;
use App\Service\SkillFinalizerService;

class CharacterBuilder
{
    public function __construct(
        private readonly LevelRepository $levelRepository,
        private readonly HitDiceCalculator $hitDiceCalculator,
        private readonly HitPointsCalculator $hitPointsCalculator,
        private readonly LevelsCalculator $levelsCalculator,
        private readonly SkillFinalizerService $skillFinalizerService,
    ) {
    }

    public function build(CharacterConfigDto $config): NewCharacter
    {
        $levels = $this->getLevels($config->levelConfigDtos);
        $abilities = $this->getAbilities($config->abilitiesConfigDto);

        return new NewCharacter(
            $config->characterName,
            $config->playerName,
            $config->campaignName,
            $this->getHitDices($levels),
            $this->getHitPoints($levels, $abilities),
            $abilities,
            $this->getSimpleLevels($levels),
            $this->getSkills($abilities, $levels),
            $config->origin,
            $config->race,
            $this->getProficiencies($levels, 'armor'),
            $this->getProficiencies($levels, 'weapon'),
            $this->getProficiencies($levels, 'tool'),
            $this->getProficiencies($levels, 'saving throw'),
            $this->getProficiencies($levels, 'skill'),
        );
    }

    private function getLevels(array $configs): array
    {
        return array_map(
            fn (LevelConfigDto $config)
            => $this->levelRepository->getByLevelAndCharacterClass(
                $config->level,
                $config->class
            ),
            $configs
        );
    }

    private function getAbilities(AbilitiesConfigDto $config): NewAbilities
    {
        return new NewAbilities(
            NewAbilityFactory::create(NewAbilityEnum::STR, $config->str),
            NewAbilityFactory::create(NewAbilityEnum::DEX, $config->dex),
            NewAbilityFactory::create(NewAbilityEnum::CON, $config->con),
            NewAbilityFactory::create(NewAbilityEnum::INT, $config->int),
            NewAbilityFactory::create(NewAbilityEnum::WIS, $config->wis),
            NewAbilityFactory::create(NewAbilityEnum::CHA, $config->cha),
        );
    }

    private function getHitDices(array $levels): array
    {
        return $this->hitDiceCalculator->newCalculate($levels);
    }

    private function getHitPoints(array $levels, NewAbilities $abilities): int
    {
        return $this->hitPointsCalculator->newCalculate($levels, $abilities->con->modifier);
    }

    private function getSimpleLevels(array $levels): array
    {
        return $this->levelsCalculator->calculate($levels);
    }

    private function getSkills(NewAbilities $abilities, array $levels): array
    {
        $result = [];

        foreach ($levels as $level) {
            $result += $this->skillFinalizerService->finalizeArray(
                $level->getSkills()->toArray(),
                $abilities,
                $levels
            );
        }

        return $result;
    }

    private function getProficiencies(array $levels, string $category): array
    {
        $result = [];

        /** @var Level $level */
        foreach ($levels as $level) {
            foreach ($level->getProficiencies() as $proficiency) {
                if ($proficiency->getCategory() === $category) {
                    $result[] = $proficiency->getName();
                }
            }
        }

        return $result;
    }
}