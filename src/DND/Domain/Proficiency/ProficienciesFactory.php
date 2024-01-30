<?php

declare(strict_types=1);

namespace DND\Domain\Proficiency;

use DND\Domain\CharacterClass\CharacterClassCollection;
use DND\Domain\Enum\ProficiencyEnum;

class ProficienciesFactory
{
    public static function create(
        CharacterClassCollection $characterClassCollection,
        array $proficiencies,
        ?array $expertProficiencies = []
    ): Proficiencies {
        $result = new Proficiencies();

        foreach ($characterClassCollection->getCharacterClasses() as $characterClass) {
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