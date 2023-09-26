<?php

namespace DND\CharacterCard;

use DND\CharacterCard\Builder\AbstractBuilder;

class CharacterCardDirector
{
    private AbstractBuilder $savingThrowsBuilder;
    private AbstractBuilder $abilitiesBuilder;
    private AbstractBuilder $skillsBuilder;
    private AbstractBuilder $proficienciesAndLanguagesBuilder;
    private AbstractBuilder $resistancesBuilder;
    private AbstractBuilder $hitDiceBuilder;
    private AbstractBuilder $titleBuilder;
    private AbstractBuilder $statsBuilder;

    public function __construct(
        AbstractBuilder $savingThrowsBuilder,
        AbstractBuilder $abilitiesBuilder,
        AbstractBuilder $skillsBuilder,
        AbstractBuilder $proficienciesAndLanguagesBuilder,
        AbstractBuilder $resistancesBuilder,
        AbstractBuilder $hitDiceBuilder,
        AbstractBuilder $titleBuilder,
        AbstractBuilder $statsBuilder,
    ) {
        $this->savingThrowsBuilder = $savingThrowsBuilder;
        $this->abilitiesBuilder = $abilitiesBuilder;
        $this->skillsBuilder = $skillsBuilder;
        $this->proficienciesAndLanguagesBuilder = $proficienciesAndLanguagesBuilder;
        $this->resistancesBuilder = $resistancesBuilder;
        $this->hitDiceBuilder = $hitDiceBuilder;
        $this->titleBuilder = $titleBuilder;
        $this->statsBuilder = $statsBuilder;
    }

    public function buildSavingThrowsSection(): string
    {
        return $this->savingThrowsBuilder->build();
    }

    public function buildAbilitiesSection(): string
    {

    }

    public function buildSkillsSection(): string
    {

    }

    public function buildProficienciesAndLanguagesSection(): string
    {

    }

    public function buildResistancesSection(): string
    {

    }

    public function buildHitDiceSection(): string
    {

    }

    public function buildTitleSection(): string
    {

    }

    public function buildStatsSection(): string
    {

    }
}
