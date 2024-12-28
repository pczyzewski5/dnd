<?php

namespace App\SectionBuilder;

class DealtDmgBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $context =  [];

        return $this->twig->render(
            'character_card/sections/dealt_dmg.html.twig',
            $context
        );
    }
}