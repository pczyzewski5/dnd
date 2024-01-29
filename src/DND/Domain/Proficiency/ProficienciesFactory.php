<?php

namespace DND\Domain\Proficiency;

use DND\Domain\CharacterClass\CharacterClass;
use DND\Domain\Enum\ProficiencyEnum;

class ProficienciesFactory
{
    public static function create(
        array $characterClasses,
        array $proficiencies,
        ?array $expertProficiencies = []
    ): Proficiencies {
        $result = new Proficiencies();

        /** @var CharacterClass $characterClass */
        foreach ($characterClasses as $characterClass) {
            foreach ($characterClass->getProficiencies() as $proficiency) {
                $result->addProficiency($proficiency);
            }
        }

        foreach ($proficiencies as $proficiency) {
            $result->addProficiency(ProficiencyEnum::from($proficiency));
        }

        foreach ($expertProficiencies as $expertProficiency) {
            $result->addExpertProficiency(ProficiencyEnum::from($expertProficiency));
        }

        return $result;
    }
}