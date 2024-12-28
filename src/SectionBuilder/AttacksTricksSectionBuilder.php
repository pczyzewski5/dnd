<?php

declare(strict_types=1);

namespace App\SectionBuilder;

class AttacksTricksSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $context =  [
            'attackCount' => 2,
        ];

        return $this->twig->render(
            'character_card/sections/attacks_tricks.html.twig',
            $context
        );
    }
}