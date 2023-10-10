<?php

namespace DND\CharacterCard\SectionBuilder;

use DND\Domain\Enum\ProficiencyEnum;

class ProficienciesLanguagesSectionBuilder extends AbstractSectionBuilder
{
    private const PROFICIENCIES = [
        // weapons
        ProficiencyEnum::SIMPLE_WEAPONS,
        ProficiencyEnum::LONGSWORD,
        ProficiencyEnum::SHORTSWORD,
        ProficiencyEnum::RAPIER,
        ProficiencyEnum::HAND_CROSSBOW,
        // armors
        ProficiencyEnum::LIGHT_ARMORS,
        // tools
        ProficiencyEnum::THIEF_TOOLS
    ];

    public function build(): string
    {
        $allCharacterProficiencies = $this->character->getProficiencies();
        $proficienciesToRender = [];

        foreach (self::PROFICIENCIES as $proficiency) {
            if ($allCharacterProficiencies->hasProficiency($proficiency)) {
                $proficienciesToRender[] = $proficiency;
            }
        }

        $context = [
            'proficiencies' => \implode(', ', $proficienciesToRender),
            'languages' => \implode(', ', $this->character->getLanguages()),
        ];

        return $this->twig->render(
            'character_card/sections/proficiencies_languages.html.twig',
            $context
        );
    }
}