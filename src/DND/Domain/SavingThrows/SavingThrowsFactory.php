<?php

namespace DND\Domain\SavingThrows;

use DND\Domain\Ability\Abilities;
use DND\Domain\Enum\ProficiencyEnum;
use DND\Domain\Proficiency\Proficiencies;

class SavingThrowsFactory
{
    public static function create(
        Abilities $abilities,
        Proficiencies $proficiencies,
        int $proficiencyBonus
    ): SavingThrows {
        return new SavingThrows(
            new SavingThrow($abilities->getStr(), $proficiencies->hasProficiency(ProficiencyEnum::STR()), $proficiencyBonus),
            new SavingThrow($abilities->getDex(), $proficiencies->hasProficiency(ProficiencyEnum::DEX()), $proficiencyBonus),
            new SavingThrow($abilities->getCon(), $proficiencies->hasProficiency(ProficiencyEnum::CON()), $proficiencyBonus),
            new SavingThrow($abilities->getInt(), $proficiencies->hasProficiency(ProficiencyEnum::INT()), $proficiencyBonus),
            new SavingThrow($abilities->getWis(), $proficiencies->hasProficiency(ProficiencyEnum::WIS()), $proficiencyBonus),
            new SavingThrow($abilities->getCha(), $proficiencies->hasProficiency(ProficiencyEnum::CHA()), $proficiencyBonus),
        );
    }
}