<?php

namespace DND\CharacterCard;

use DND\Character\Character;
use DND\CharacterCard\SectionBuilder\AbilitiesSectionBuilder;
use DND\CharacterCard\SectionBuilder\SavingThrowsSectionBuilder;
use DND\CharacterCard\SectionBuilder\SkillsSectionBuilder;
use DND\CharacterCard\SectionBuilder\StatsSectionBuilder;
use DND\CharacterCard\SectionBuilder\TitleSectionBuilder;
use Twig\Environment;

class CharacterCardBuilder
{
    private string $stylesPath;
    private Environment $twig;

    public function __construct(string $stylesPath, Environment $twig)
    {
        $this->stylesPath = $stylesPath;
        $this->twig = $twig;
    }

    public function build(Character $character): string
    {
        $context = [
            'savingThrowsSection' => (new SavingThrowsSectionBuilder($character, $this->twig))->build(),
            'abilitiesSection' => (new AbilitiesSectionBuilder($character, $this->twig))->build(),
            'skillsSection' => (new SkillsSectionBuilder($character, $this->twig))->build(),
            'titleSection' => (new TitleSectionBuilder($character, $this->twig))->build(),
            'statsSection' => (new StatsSectionBuilder($character, $this->twig))->build(),
        ];

        $context['styles'] = \file_get_contents($this->stylesPath);

        return $this->twig->render(
            'character_card/character_card_front.html.twig',
            $context
        );
    }
}