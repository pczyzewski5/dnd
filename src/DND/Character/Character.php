<?php

namespace DND\Character;

use DND\CharacterClass\CharacterClass;
use DND\Domain\Ability\Abilities;
use DND\Domain\Enum\Alignment;
use DND\Domain\Enum\Origin;
use DND\Domain\SavingThrows\SavingThrows;
use DND\Race\Race;
use DND\Domain\Skills\AbilitySkills;

class Character
{
    private string $characterName;
    private string $playerName;
    private Race $race;
    private Origin $origin;
    private Alignment $alignment;
    private Level $level;
    private CharacterClass $characterClass;
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
        Race           $race,
        Origin         $origin,
        Alignment      $alignment,
        Level          $level,
        CharacterClass $characterClass,
        Abilities      $abilities,
        SavingThrows   $savingThrows,
        AbilitySkills  $skills,
        array          $proficiencies,
        array          $languages,
        array          $resistances,
        array          $immunities,
    ) {
        $this->characterName = $characterName;
        $this->playerName = $playerName;
        $this->race = $race;
        $this->origin = $origin;
        $this->alignment = $alignment;
        $this->level = $level;
        $this->characterClass = $characterClass;
        $this->abilities = $abilities;
        $this->savingThrows = $savingThrows;
        $this->skills = $skills;
        $this->proficiencies = $proficiencies;
        $this->languages = $languages;
        $this->resistances = $resistances;
        $this->immunities = $immunities;
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

    public function getCharacterClass(): CharacterClass
    {
        return $this->characterClass;
    }

    public function getCharacterName(): string
    {
        return $this->characterName;
    }

    public function getPlayerName(): string
    {
        return $this->playerName;
    }

    public function getRace(): Race
    {
        return $this->race;
    }

    public function getOrigin(): Origin
    {
        return $this->origin;
    }

    public function getAlignment(): Alignment
    {
        return $this->alignment;
    }

    public function getLevel(): Level
    {
        return $this->level;
    }

    public function getAbilities(): Abilities
    {
        return $this->abilities;
    }

    public function getSavingThrows(): SavingThrows
    {
        return $this->savingThrows;
    }

    public function getSkills(): AbilitySkills
    {
        return $this->skills;
    }
}