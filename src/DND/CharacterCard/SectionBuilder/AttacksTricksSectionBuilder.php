<?php

namespace DND\CharacterCard\SectionBuilder;

use DND\Skill\Skills\Spellcasting;

class AttacksTricksSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context =  [
            'attackCount' => $this->character->getAttackCount(),
        ];

        foreach ($this->character->getActiveSkills() as $skill) {
            if ($skill instanceof Spellcasting) {
                $context = \array_merge($this->character->getSpellcastingData(), $context);
                break;
            }
        }

        return $this->twig->render(
            'character_card/sections/attacks_tricks.html.twig',
            $context
        );
    }
}