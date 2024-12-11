<?php

declare(strict_types=1);

namespace App\CharacterCard\SectionBuilder;

use App\Skill\Skills\Spellcasting;

class AttacksTricksSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $context =  [
            'attackCount' => $this->character->getAttackCount(),
        ];

        foreach ($this->character->getSkills()->getActiveSkills() as $skill) {
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