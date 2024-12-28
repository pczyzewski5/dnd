<?php

namespace App\SectionBuilder;

class HpSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $context =  [];

        return $this->twig->render(
            'character_card/sections/hp.html.twig',
            $context
        );
    }
}