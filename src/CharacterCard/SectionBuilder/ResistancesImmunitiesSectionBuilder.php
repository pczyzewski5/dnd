<?php

declare(strict_types=1);

namespace App\CharacterCard\SectionBuilder;

use App\Enum\SkillEnum;

class ResistancesImmunitiesSectionBuilder extends AbstractSectionBuilder
{
    private const SKILL_TO_RESISTANCE = [
        SkillEnum::ACID_RESISTANCE => 'acid',
        SkillEnum::DIVINE_HEALTH => 'diseases',
        SkillEnum::HELLISH_RESISTANCE => 'fire',
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