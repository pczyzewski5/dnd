<?php

declare(strict_types=1);

namespace DND\Domain\CharacterCard\SectionBuilder;

use DND\Domain\Skill\Skills\AcidResistance;
use DND\Domain\Skill\Skills\DivineHealth;
use DND\Domain\Skill\Skills\HellishResistance;

class ResistancesImmunitiesSectionBuilder extends AbstractSectionBuilder
{
    private const SKILL_TO_RESISTANCE = [
        AcidResistance::class => 'acid',
        DivineHealth::class => 'diseases',
        HellishResistance::class => 'fire',
    ];

    public function build(): string
    {
        $resistances = [];

        foreach (self::SKILL_TO_RESISTANCE as $skill => $resistance) {
            if ($this->character->getSkills()->hasSkill($skill)) {
                $resistances[] = $resistance;
            }
        }

        return $this->twig->render(
            'character_card/sections/resistances_immunities.html.twig', [
            'resistances' => \implode(', ', $resistances),
            'immunities' => []
        ]);
    }
}