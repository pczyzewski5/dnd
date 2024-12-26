<?php

namespace App\Service;

use App\Character\Character;
use App\CharacterCard\SectionBuilder\SimpleCharacterStatsBuilder;
use App\NewCharacter\NewCharacter;
use App\SectionBuilder\AbilitiesSectionBuilder;
use App\SectionBuilder\AbilitySkillsSectionBuilder;
use App\SectionBuilder\DealtDmgBuilder;
use App\SectionBuilder\HpSectionBuilder;
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
        $emptyContext = [
            'savingThrowsSection' => '',
            'statsSection' => '',
            'resistancesImmunitiesSection' => '',

            'passivePerceptionIntuitionSection' => '',
            'hitDiceSection' => '',
            'proficienciesLanguagesSection' => '',
            'skillsCounterSection' => '',
            'attacksTricksSection' => '',
            'skillsSection' => '',
        ];
        $newContext = [
            'abilitySkillsSection' => (new AbilitySkillsSectionBuilder($character, $this->twig))->build(),
            'abilitiesSection' => (new AbilitiesSectionBuilder($character, $this->twig))->build(),
            'titleSection' => (new TitleSectionBuilder($character, $this->twig))->build(),
            'dealtDmgSection' => (new DealtDmgBuilder($character, $this->twig))->build(),
            'hpSection' => (new HpSectionBuilder($character, $this->twig))->build(),
            'opaqueStats' => $opaqueStats
        ];

        $context = array_merge($emptyContext, $newContext);

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
