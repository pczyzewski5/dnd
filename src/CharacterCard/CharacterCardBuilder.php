<?php

namespace App\CharacterCard;

use App\Character\Character;
use App\CharacterCard\SectionBuilder\AbilitiesSectionBuilder;
use App\CharacterCard\SectionBuilder\AbilitySkillsSectionBuilder;
use App\CharacterCard\SectionBuilder\AttacksTricksSectionBuilder;
use App\CharacterCard\SectionBuilder\DealtDmgBuilder;
use App\CharacterCard\SectionBuilder\HitDiceSectionBuilder;
use App\CharacterCard\SectionBuilder\HpSectionBuilder;
use App\CharacterCard\SectionBuilder\PassivePerceptionIntuitionSectionBuilder;
use App\CharacterCard\SectionBuilder\ProficienciesLanguagesSectionBuilder;
use App\CharacterCard\SectionBuilder\ResistancesImmunitiesSectionBuilder;
use App\CharacterCard\SectionBuilder\SavingThrowsSectionBuilder;
use App\CharacterCard\SectionBuilder\SkillsCounterSectionBuilder;
use App\CharacterCard\SectionBuilder\SkillsSectionBuilder;
use App\CharacterCard\SectionBuilder\StatsSectionBuilder;
use App\CharacterCard\SectionBuilder\TitleSectionBuilder;
use Twig\Environment;

class CharacterCardBuilder
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function build(Character $character, $opaqueStats = false): string
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
            'opaqueStats' => $opaqueStats
        ];

        return $this->twig->render('character_card/character_card_front.html.twig', $context);
    }
}
