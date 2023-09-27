<?php

namespace DND\CharacterCard;

use DND\Character\Character;
use DND\CharacterCard\SectionBuilder\AbstractSectionBuilder;

class CharacterCardDirector
{
    private AbstractSectionBuilder $savingThrowsBuilder;
    private AbstractSectionBuilder $abilitiesBuilder;
    private AbstractSectionBuilder $skillsBuilder;
    private AbstractSectionBuilder $proficienciesAndLanguagesBuilder;
    private AbstractSectionBuilder $resistancesBuilder;
    private AbstractSectionBuilder $hitDiceBuilder;
    private AbstractSectionBuilder $titleBuilder;
    private AbstractSectionBuilder $statsBuilder;

    public function __construct(
        AbstractSectionBuilder $savingThrowsBuilder,
        AbstractSectionBuilder $abilitiesBuilder,
        AbstractSectionBuilder $skillsBuilder,
        AbstractSectionBuilder $proficienciesAndLanguagesBuilder,
        AbstractSectionBuilder $resistancesBuilder,
        AbstractSectionBuilder $hitDiceBuilder,
        AbstractSectionBuilder $titleBuilder,
        AbstractSectionBuilder $statsBuilder,
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

    public function buildSavingThrowsSection(Character $character): string
    {
        return $this->savingThrowsBuilder->build($character);
    }

    public function buildAbilitiesSection(Character $character): string
    {
        return $this->abilitiesBuilder->build($character);
    }

    public function buildSkillsSection(Character $character): string
    {
        return $this->skillsBuilder->build($character);
    }

    public function buildProficienciesAndLanguagesSection(Character $character): string
    {

    }

    public function buildResistancesSection(Character $character): string
    {

    }

    public function buildHitDiceSection(Character $character): string
    {

    }

    public function buildTitleSection(Character $character): string
    {
        return $this->titleBuilder->build($character);
    }

    public function buildStatsSection(): string
    {

    }
}
