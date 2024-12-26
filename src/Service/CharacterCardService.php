<?php

namespace App\Service;

use App\Character\Character;
use App\CharacterCard\SectionBuilder\SimpleCharacterStatsBuilder;
use App\NewCharacter\NewCharacter;
use App\SectionBuilder\AbilitiesSectionBuilder;
use App\SectionBuilder\AbilitySkillsSectionBuilder;
use App\SectionBuilder\AttacksTricksSectionBuilder;
use App\SectionBuilder\DealtDmgBuilder;
use App\SectionBuilder\HitDiceSectionBuilder;
use App\SectionBuilder\HpSectionBuilder;
use App\SectionBuilder\Passives;
use App\SectionBuilder\ProficienciesLanguagesSectionBuilder;
use App\SectionBuilder\ResistancesImmunitiesSectionBuilder;
use App\SectionBuilder\SavingThrowsSectionBuilder;
use App\SectionBuilder\SkillsCounterSectionBuilder;
use App\SectionBuilder\SkillsSectionBuilder;
use App\SectionBuilder\StatsSectionBuilder;
use App\SectionBuilder\TitleSectionBuilder;
use Twig\Environment;

use function array_merge;

class CharacterCardService
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function getFrontpage(NewCharacter $character, $opaqueStats = false): string
    {
        $context = [
            'statsSection' => (new StatsSectionBuilder($character, $this->twig))->build(),
            'attacksTricksSection' => (new AttacksTricksSectionBuilder($character, $this->twig))->build(),
            'skillsCounterSection' => (new SkillsCounterSectionBuilder($character, $this->twig))->build(),
            'skillsSection' => (new SkillsSectionBuilder($character, $this->twig))->build(),
            'hitDiceSection' => (new HitDiceSectionBuilder($character, $this->twig))->build(),
            'passivePerceptionIntuitionSection' => (new Passives($character, $this->twig))->build(),
            'resistancesImmunitiesSection' => (new ResistancesImmunitiesSectionBuilder($character, $this->twig))->build(),
            'proficienciesLanguagesSection' => (new ProficienciesLanguagesSectionBuilder($character, $this->twig))->build(),
            'savingThrowsSection' => (new SavingThrowsSectionBuilder($character, $this->twig))->build(),
            'abilitySkillsSection' => (new AbilitySkillsSectionBuilder($character, $this->twig))->build(),
            'abilitiesSection' => (new AbilitiesSectionBuilder($character, $this->twig))->build(),
            'titleSection' => (new TitleSectionBuilder($character, $this->twig))->build(),
            'dealtDmgSection' => (new DealtDmgBuilder($character, $this->twig))->build(),
            'hpSection' => (new HpSectionBuilder($character, $this->twig))->build(),
            'opaqueStats' => $opaqueStats
        ];

        return $this->twig->render('character_card/character_card_frontpage.html.twig', $context);
    }

    public function getBackpage(Character $character, $opaqueStats = false): string
    {
        $context = [
            'simpleCharacterStats' => (new SimpleCharacterStatsBuilder($character, $this->twig))->build(),
        ];

        return $this->twig->render('character_card/character_card_backpage.html.twig', $context);
    }
}
