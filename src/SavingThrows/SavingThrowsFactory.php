<?php

namespace App\SavingThrows;

use App\Ability\Abilities;
use App\Level\Levels;
use App\Proficiency\Proficiencies;

class SavingThrowsFactory
{
    public static function create(
        Abilities $abilities,
        Proficiencies $proficiencies,
        Levels $levels
    ): SavingThrows {
        $proficiencyBonus = $levels->getProficiencyBonus();

        return new SavingThrows(
            new SavingThrow($abilities->getStr(), $proficiencies, $proficiencyBonus),
            new SavingThrow($abilities->getDex(), $proficiencies, $proficiencyBonus),
            new SavingThrow($abilities->getCon(), $proficiencies, $proficiencyBonus),
            new SavingThrow($abilities->getInt(), $proficiencies, $proficiencyBonus),
            new SavingThrow($abilities->getWis(), $proficiencies, $proficiencyBonus),
            new SavingThrow($abilities->getCha(), $proficiencies, $proficiencyBonus),
        );
    }
}