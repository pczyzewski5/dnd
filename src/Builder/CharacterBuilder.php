<?php

declare(strict_types=1);

namespace App\Builder;

use App\Ability\NewAbilities;
use App\Calculator\HitDiceCalculator;
use App\Calculator\HitPointsCalculator;
use App\Calculator\LevelsCalculator;
use App\Collection\Levels;
use App\NewCharacter\CharacterConfig;
use App\NewCharacter\NewCharacter;
use App\Service\SkillFinalizerService;

use Symfony\Component\Validator\Validator\ValidatorInterface;

use function var_dump;

class CharacterBuilder
{
    public function __construct(

        private readonly HitDiceCalculator $hitDiceCalculator,
        private readonly HitPointsCalculator $hitPointsCalculator,
        private readonly LevelsCalculator $levelsCalculator,
        private readonly SkillFinalizerService $skillFinalizerService,
    ) {
    }

    public function build(CharacterConfig $characterConfig): NewCharacter
    {
        $levels = $characterConfig->levels;
        $abilities = $characterConfig->abilities;

        return new NewCharacter(
            $characterConfig->characterName,
            $characterConfig->playerName,
            $characterConfig->campaignName,
            $this->hitDiceCalculator->newCalculate($levels),
            $this->hitPointsCalculator->newCalculate($levels, $abilities->con),
            $abilities,
            $this->levelsCalculator->calculate($levels),
            $this->getSkills($abilities, $levels),
            $characterConfig->origin->getName(),
            $characterConfig->race->getName(),
            $this->getProficiencies($levels, 'armor'),
            $this->getProficiencies($levels, 'weapon'),
            $this->getProficiencies($levels, 'tool'),
            $this->getProficiencies($levels, 'saving throw'),
            $this->getProficiencies($levels, 'skill'),
        );
    }

    private function getSkills(NewAbilities $abilities, Levels $levels): array
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

    private function getProficiencies(Levels $levels, string $proficiencyCategory): array
    {
        $result = [];

        foreach ($levels as $level) {
            foreach ($level->getProficiencies() as $proficiency) {
                if ($proficiency->getCategory() === $proficiencyCategory) {
                    $result[] = $proficiency->getName();
                }
            }
        }

        return $result;
    }
}