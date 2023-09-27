<?php

namespace DND\CharacterCard;

use DND\Character\Character;
use DND\CharacterCard\Builder\AbstractBuilder;
use DND\Domain\Ability\Abilities;
use DND\Domain\SavingThrows\SavingThrows;

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
