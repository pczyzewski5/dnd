<?php

namespace DND\Domain\Proficiency;

use DND\CharacterClass\CharacterClass;
use DND\Domain\Enum\ProficiencyEnum;

class ProficienciesFactory
{
    public static function create(
        CharacterClass $characterClass,
        array $proficiencies,
        ?array $expertProficiencies = [],
        ?CharacterClass $characterSubclass
    ): Proficiencies {
        $result = new Proficiencies();

        foreach ($characterClass->getProficiencies() as $proficiency) {
            $result->addProficiency(ProficiencyEnum::from($proficiency));
        }
        foreach ($proficiencies as $proficiency) {
            $result->addProficiency(ProficiencyEnum::from($proficiency));
        }
        foreach ($expertProficiencies as $expertProficiency) {
            $result->addExpertProficiency(ProficiencyEnum::from($expertProficiency));
        }
        if (null !== $characterSubclass) {
            foreach ($characterSubclass->getMulticlassProficiencies() as $proficiency) {
                $result->addProficiency(ProficiencyEnum::from($proficiency));
            }
        }

        return $result;
    }
}