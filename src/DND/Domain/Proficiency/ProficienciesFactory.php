<?php

namespace DND\Domain\Proficiency;

use DND\Domain\Enum\ProficiencyEnum;

class ProficienciesFactory
{
    public static function fromArray(array $proficiencies, ?array $expertProficiencies = []): Proficiencies
    {
        $result = new Proficiencies();

        foreach ($proficiencies as $proficiency) {
            $result->addProficiency(ProficiencyEnum::from($proficiency));
        }
        foreach ($expertProficiencies as $expertProficiency) {
            $result->addExpertProficiency(ProficiencyEnum::from($expertProficiency));
        }

        return $result;
    }
}