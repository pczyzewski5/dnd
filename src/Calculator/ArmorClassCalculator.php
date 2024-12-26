<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Ability\Abilities;
use App\Ability\Abilities;
use App\Enum\SkillEnum;
use App\Proficiency\NewProficiencies;
use App\Skill\Skills;

use function in_array;

class ArmorClassCalculator
{
    public static function calculate(Abilities $abilities, Skills $skills): int
    {
        $dexModifier = $abilities->getDex()->getModifier();

        $results = [10 + $dexModifier];

        if ($skills->hasSkill(SkillEnum::UNARMORED_DEFENSE)) {
            $results[] = $abilities->getCon()->getModifier() + $dexModifier + 10;
        }
        if ($skills->hasSkill(SkillEnum::NATURAL_ARMOR)) {
            $results[] = $dexModifier + 13;
        }

        $armorClass = \max($results);

        if ($skills->hasSkill(SkillEnum::FIGHTING_STYLE_PROTECTION)) {
            $armorClass += 1;
        }

        return $armorClass;
    }

    public static function newCalculate(
        Abilities $abilities,
    ): int {
        $baseValue = 10;

        return $baseValue + $abilities->dex->modifier;
    }
}