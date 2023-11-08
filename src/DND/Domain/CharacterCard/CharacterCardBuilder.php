<?php

namespace DND\Domain\CharacterCard;

use DND\Domain\Character\Character;
use DND\Domain\CharacterCard\SectionBuilder\AbilitiesSectionBuilder;
use DND\Domain\CharacterCard\SectionBuilder\AbilitySkillsSectionBuilder;
use DND\Domain\CharacterCard\SectionBuilder\AttacksTricksSectionBuilder;
use DND\Domain\CharacterCard\SectionBuilder\DealtDmgBuilder;
use DND\Domain\CharacterCard\SectionBuilder\HitDiceSectionBuilder;
use DND\Domain\CharacterCard\SectionBuilder\HpSectionBuilder;
use DND\Domain\CharacterCard\SectionBuilder\PassivePerceptionIntuitionSectionBuilder;
use DND\Domain\CharacterCard\SectionBuilder\ProficienciesLanguagesSectionBuilder;
use DND\Domain\CharacterCard\SectionBuilder\ResistancesImmunitiesSectionBuilder;
use DND\Domain\CharacterCard\SectionBuilder\SavingThrowsSectionBuilder;
use DND\Domain\CharacterCard\SectionBuilder\SkillsCounterSectionBuilder;
use DND\Domain\CharacterCard\SectionBuilder\SkillsSectionBuilder;
use DND\Domain\CharacterCard\SectionBuilder\StatsSectionBuilder;
use DND\Domain\CharacterCard\SectionBuilder\TitleSectionBuilder;
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
            'titleSection' => (new TitleSectionBuilder($character, $this->twig))->build(),
            'statsSection' => (new StatsSectionBuilder($character, $this->twig))->build(),
            'resistancesImmunitiesSection' => (new ResistancesImmunitiesSectionBuilder($character, $this->twig))->build(),
            'abilitySkillsSection' => (new AbilitySkillsSectionBuilder($character, $this->twig))->build(),
            'passivePerceptionIntuitionSection' => (new PassivePerceptionIntuitionSectionBuilder($character, $this->twig))->build(),
            'hpSection' => (new HpSectionBuilder($character, $this->twig))->build(),
            'hitDiceSection' => (new HitDiceSectionBuilder($character, $this->twig))->build(),
            'dealtDmgSection' => (new DealtDmgBuilder($character, $this->twig))->build(),
            'proficienciesLanguagesSection' => (new ProficienciesLanguagesSectionBuilder($character, $this->twig))->build(),
            'skillsCounterSection' => (new SkillsCounterSectionBuilder($character, $this->twig))->build(),
            'attacksTricksSection' => (new AttacksTricksSectionBuilder($character, $this->twig))->build(),
            'skillsSection' => (new SkillsSectionBuilder($character, $this->twig))->build(),
        ];

        $context['styles'] = \file_get_contents($this->stylesPath);

        return $this->twig->render(
            'character_card/character_card_front.html.twig',
            $context
        );
    }
}
