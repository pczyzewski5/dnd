<?php

namespace DND\Domain\Resistances;

class ResistancesMapper
{
    private const SKILL_TO_RESISTANCE = [
        \DND\Domain\Skill\Skills\AcidResistance::class => 'acid',
        \DND\Domain\Skill\Skills\DivineHealth::class => 'diseases',
        \DND\Domain\Skill\Skills\HellishResistance::class => 'fire',
    ];

    public static function getResistances(array $skills): array
    {
        $result = [];

        foreach ($skills as $skill) {
            if (\array_key_exists($skill::class, self::SKILL_TO_RESISTANCE)) {
                $result[] = self::SKILL_TO_RESISTANCE[$skill::class];
            }
        }

        return $result;
    }
}
