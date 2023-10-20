<?php

namespace DND\Character;

use DND\Skill\Skills;

class ResistancesMapper
{
    private const SKILL_TO_RESISTANCE = [
        Skills\AcidResistance::class => 'acid',
        Skills\DivineHealth::class => 'diseases',
        Skills\HellishResistance::class => 'fire',
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
