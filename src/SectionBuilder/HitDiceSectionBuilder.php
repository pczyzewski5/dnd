<?php

namespace App\SectionBuilder;

class HitDiceSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $context =  [
            'hitDices' => $this->character->hitDices,
        ];

        return $this->twig->render(
            'character_card/sections/hit_dice.html.twig',
            $context
        );
    }
}