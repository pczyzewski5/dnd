<?php

namespace DND\Character;

use DND\Calculators\ArmorClassCalculator;
use DND\Calculators\DistanceCalculator;
use DND\Calculators\HitPointsCalculator;
use DND\Calculators\InitiativeCalculator;
use DND\Calculators\ProficiencyBonusCalculator;
use DND\CharacterClass\CharacterClass;
use DND\CharacterClass\CharacterClassHelper;
use DND\Domain\Ability\Abilities;
use DND\Domain\Ability\AbilityMerger;
use DND\Domain\AbilitySkills\AbilitySkillsFactory;
use DND\Domain\Enum\AlignmentEnum;
use DND\Domain\Enum\OriginEnum;
use DND\Domain\Proficiency\Proficiencies;
use DND\Domain\SavingThrows\SavingThrows;
use DND\Domain\SavingThrows\SavingThrowsFactory;
use DND\Domain\AbilitySkills\AbilitySkills;
use DND\Race\Race;
use DND\Skill\Skills;

class Character
{
    private string $characterName;
    private string $playerName;
    private string $campaignName;
    private Race $race;
    private OriginEnum $origin;
    private AlignmentEnum $alignment;
    private Levels $levels;
    private Abilities $abilities;
    private Proficiencies $proficiencies;
    private array $languages;
    private array $resistances;
    private array $immunities;
    private Skills $skills;
    private HitDices $hitDices;
    private CharacterClass $characterClass;
    private ?CharacterClass $characterSubclass;

    public function __construct(
        string $characterName,
        string $playerName,
        string $campaignName,
        Race $race,
        OriginEnum $origin,
        AlignmentEnum $alignment,
        Levels $levels,
        Abilities $abilities,
        Proficiencies $proficiencies,
        array $languages,
        array $resistances,
        array $immunities,
    ) {
        $this->campaignName = $campaignName;
        $this->characterName = $characterName;
        $this->playerName = $playerName;
        $this->race = $race;
        $this->origin = $origin;
        $this->alignment = $alignment;
        $this->levels = $levels;
        $this->proficiencies = $proficiencies;
        $this->languages = $languages;
        $this->resistances = $resistances;
        $this->immunities = $immunities;

        $characterClassHelper = new CharacterClassHelper($levels);
        $this->hitDices = $characterClassHelper->getHitDices();
        $this->characterClass = $characterClassHelper->getCharacterClass();
        $this->characterSubclass = $characterClassHelper->getCharacterSubclass();

        $this->skills = new Skills();
        $this->skills->addSkills($race->getSkills());
        $this->skills->addSkills($characterClassHelper->getSkills());

        $this->abilities = AbilityMerger::merge($abilities, $race);
        $this->proficiencies->merge($characterClassHelper->getProficiencies());
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

    public function getProficiencies(): Proficiencies
    {
        return $this->proficiencies;
    }

    public function getLanguages(): array
    {
        return \array_unique(
            \array_merge($this->race->getLanguages(), $this->languages)
        );
    }

    public function getCharacterName(): string
    {
        return $this->characterName;
    }

    public function getCharacterClass(): CharacterClass
    {
        return $this->characterClass;
    }

    public function getCharacterSubclass(): ?CharacterClass
    {
        return $this->characterSubclass;
    }

    public function getPlayerName(): string
    {
        return $this->playerName;
    }

    public function getRace(): Race
    {
        return $this->race;
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

    public function getOrigin(): OriginEnum
    {
        return $this->origin;
    }

    public function getAlignment(): AlignmentEnum
    {
        return $this->alignment;
    }

    public function getActualLevel(): int
    {
        return \count($this->levels->getLevels());
    }

    public function getAbilities(): Abilities
    {
        return $this->abilities;
    }

    public function getSavingThrows(): SavingThrows
    {
        return SavingThrowsFactory::create($this->abilities, $this->proficiencies, $this->getProficiencyBonus());
    }

    public function getAbilitySkills(): AbilitySkills
    {
        return AbilitySkillsFactory::create($this->abilities, $this->proficiencies, $this->getProficiencyBonus());
    }

    public function getSkills(): array
    {
        return $this->skills->getSkills($this);
    }

    public function getProficiencyBonus(): int
    {
        return ProficiencyBonusCalculator::calculate($this->getActualLevel());
    }

    public function getHitDices(): HitDices
    {
        return $this->hitDices;
    }

    public function getHitPoints(): int
    {
        return HitPointsCalculator::calculate($this->characterClass, $this->hitDices, $this->abilities);
    }
}