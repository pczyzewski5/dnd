<?php

namespace DND\Character;

use DND\Calculators\ArmorClassCalculator;
use DND\Calculators\DistanceCalculator;
use DND\Calculators\HitDiceCalculator;
use DND\Calculators\HitPointsCalculator;
use DND\Calculators\InitiativeCalculator;
use DND\CharacterClass\CharacterClass;
use DND\Domain\Ability\Abilities;
use DND\Domain\Enum\AlignmentEnum;
use DND\Domain\Enum\OriginEnum;
use DND\Domain\Proficiency\Proficiencies;
use DND\Domain\SavingThrows\SavingThrows;
use DND\Domain\AbilitySkills\AbilitySkills;
use DND\Race\Race;
use DND\Skill\Skills;

class Character
{
    private CharacterClass $characterClass;
    private AbilitySkills $abilitySkills;
    private Proficiencies $proficiencies;
    private SavingThrows $savingThrows;
    private AlignmentEnum $alignment;
    private Abilities $abilities;
    private OriginEnum $origin;
    private Skills $skills;
    private Levels $levels;
    private Race $race;
    private string $characterName;
    private string $campaignName;
    private string $playerName;
    private array $resistances;
    private array $immunities;
    private array $languages;
    private ?CharacterClass $characterSubclass;

    public function __construct(
        CharacterClass $characterClass,
        AbilitySkills $abilitySkills,
        Proficiencies $proficiencies,
        SavingThrows $savingThrows,
        AlignmentEnum $alignment,
        Abilities $abilities,
        OriginEnum $origin,
        Skills $skills,
        Levels $levels,
        Race $race,
        string $characterName,
        string $campaignName,
        string $playerName,
        array $resistances,
        array $immunities,
        array $languages,
        ?CharacterClass $characterSubclass
    ) {
        $this->characterClass = $characterClass;
        $this->abilitySkills = $abilitySkills;
        $this->proficiencies = $proficiencies;
        $this->savingThrows = $savingThrows;
        $this->alignment = $alignment;
        $this->abilities = $abilities;
        $this->origin = $origin;
        $this->skills = $skills;
        $this->levels = $levels;
        $this->race = $race;
        $this->characterName = $characterName;
        $this->campaignName = $campaignName;
        $this->playerName = $playerName;
        $this->resistances = $resistances;
        $this->immunities = $immunities;
        $this->languages = $languages;
        $this->characterSubclass = $characterSubclass;
    }

    public function getSpeed(): float
    {
        return DistanceCalculator::metersToHex($this->race->getSpeed());
    }

    public function getNightvision(): float
    {
        return DistanceCalculator::metersToHex($this->race->getNightvision());
    }

    public function getInitiative(): int
    {
        return InitiativeCalculator::calculate($this->abilities);
    }

    public function getArmorClassWithoutArmor(): int
    {
        return ArmorClassCalculator::calculate($this->abilities);
    }

    public function getHitDices(): array
    {
        return HitDiceCalculator::calculate($this->levels);
    }

    public function getHitPoints(): int
    {
        return HitPointsCalculator::calculate($this->abilities, $this->levels);
    }

    public function getCharacterClass(): CharacterClass
    {
        return $this->characterClass;
    }

    public function getAbilitySkills(): AbilitySkills
    {
        return $this->abilitySkills;
    }

    public function getProficiencies(): Proficiencies
    {
        return $this->proficiencies;
    }

    public function getSavingThrows(): SavingThrows
    {
        return $this->savingThrows;
    }

    public function getAlignment(): AlignmentEnum
    {
        return $this->alignment;
    }

    public function getAbilities(): Abilities
    {
        return $this->abilities;
    }

    public function getOrigin(): OriginEnum
    {
        return $this->origin;
    }

    public function getSkills(): array
    {
        return $this->skills->getSkills($this);
    }

    public function getRace(): Race
    {
        return $this->race;
    }

    public function getCharacterName(): string
    {
        return $this->characterName;
    }

    public function getCampaignName(): string
    {
        return $this->campaignName;
    }

    public function getPlayerName(): string
    {
        return $this->playerName;
    }

    public function getResistances(): array
    {
        return $this->resistances;
    }

    public function getImmunities(): array
    {
        return $this->immunities;
    }

    public function getLanguages(): array
    {
        return \array_unique(
            \array_merge($this->race->getLanguages(), $this->languages)
        );
    }

    public function getCharacterSubclass(): ?CharacterClass
    {
        return $this->characterSubclass ?? null;
    }

    public function getProficiencyBonus(): int
    {
        return $this->levels->getProficiencyBonus();
    }

    public function getActualLevel(): int
    {
        return \count($this->levels->getLevels());
    }
}
