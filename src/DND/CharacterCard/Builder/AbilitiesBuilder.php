<?php

namespace DND\CharacterCard\Builder;

use DND\Domain\Ability\Abilities;

class AbilitiesBuilder extends AbstractBuilder
{
    private Abilities $abilities;

    public function setAbilities(Abilities $abilities): void
    {
        $this->abilities = $abilities;
    }

    public function build(): string
    {
        $context =  [
            'abilities' => $this->abilities,
            'styles' => \file_get_contents($this->stylesPath)
        ];

        return $this->twig->render(
            'character_card/sections/abilities.html.twig',
            $context
        );
    }
}