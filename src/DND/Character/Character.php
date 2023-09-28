<?php

namespace DND\Character;

use DND\Domain\Ability\Abilities;
use DND\Domain\Enum\AlignmentEnum;
use DND\Domain\Enum\OriginEnum;
use DND\Domain\Enum\RaceEnum;
use DND\Domain\SavingThrows\SavingThrows;
use DND\Domain\Skills\AbilitySkills;

class Character
{
    private string $characterName;
    private string $playerName;
    private string $campaignName;
    private RaceEnum $race;
    private OriginEnum $origin;
    private AlignmentEnum $alignment;
    private Levels $levels;
    private Abilities $abilities;
    private SavingThrows $savingThrows;
    private AbilitySkills $skills;
    private array $proficiencies;
    private array $languages;
    private array $resistances;
    private array $immunities;

    public function __construct(
        string         $characterName,
        string         $playerName,
        string         $campaignName,
        RaceEnum       $race,
        OriginEnum     $origin,
        AlignmentEnum  $alignment,
        Levels         $levels,
        Abilities      $abilities,
        SavingThrows   $savingThrows,
        AbilitySkills  $skills,
        array          $proficiencies,
        array          $languages,
        array          $resistances,
        array          $immunities,
    ) {
        $this->campaignName = $campaignName;
        $this->characterName = $characterName;
        $this->playerName = $playerName;
        $this->race = $race;
        $this->origin = $origin;
        $this->alignment = $alignment;
        $this->levels = $levels;
        $this->abilities = $abilities;
        $this->savingThrows = $savingThrows;
        $this->skills = $skills;
        $this->proficiencies = $proficiencies;
        $this->languages = $languages;
        $this->resistances = $resistances;
        $this->immunities = $immunities;
    }

    public function getCampaignName(): string
    {
        return $this->campaignName;
    }

    public function getResistances(): array
    {
        return $this->resistances;
    }

    public function getImmunities(): array
    {
        return $this->immunities;
    }

    public function getProficiencies(): array
    {
        return $this->proficiencies;
    }

    public function getLanguages(): array
    {
        return $this->languages;
    }

    public function getCharacterName(): string
    {
        return $this->characterName;
    }

    public function getPlayerName(): string
    {
        return $this->playerName;
    }

    public function getRace(): RaceEnum
    {
        return $this->race;
    }

    public function getOrigin(): OriginEnum
    {
        return $this->origin;
    }

    public function getAlignment(): AlignmentEnum
    {
        return $this->alignment;
    }

    public function getLevels(): Levels
    {
        return $this->levels;
    }

    public function getAbilities(): Abilities
    {
        return $this->abilities;
    }

    public function getSavingThrows(): SavingThrows
    {
        return $this->savingThrows;
    }

    public function getAbilitySkills(): AbilitySkills
    {
        return $this->skills;
    }
}