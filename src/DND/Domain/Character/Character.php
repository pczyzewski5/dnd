<?php

declare(strict_types=1);

namespace DND\Domain\Character;

use DND\Domain\Ability\Abilities;
use DND\Domain\AbilitySkills\AbilitySkills;
use DND\Domain\Calculators\ArmorClassCalculator;
use DND\Domain\Calculators\AttackCountCalculator;
use DND\Domain\Calculators\DistanceCalculator;
use DND\Domain\Calculators\HitDiceCalculator;
use DND\Domain\Calculators\HitPointsCalculator;
use DND\Domain\Calculators\InitiativeCalculator;
use DND\Domain\Calculators\SpeedCalculator;
use DND\Domain\CharacterClass\CharacterClass;
use DND\Domain\Enum\AlignmentEnum;
use DND\Domain\Level\Levels;
use DND\Domain\Proficiency\Proficiencies;
use DND\Domain\Race\Race;
use DND\Domain\SavingThrows\SavingThrows;
use DND\Domain\Skill\Skills;
use DND\Domain\Skill\SkillsFactory;
use DND\Domain\Spellcasting\Spellcasting;

class Character
{
    private string $id;
    private array $characterClasses;
    private AbilitySkills $abilitySkills;
    private Proficiencies $proficiencies;
    private SavingThrows $savingThrows;
    private AlignmentEnum $alignment;
    private Abilities $abilities;
    private string $origin;
    private Levels $levels;
    private Race $race;
    private string $characterName;
    private string $campaignName;
    private string $playerName;
    private array $languages;


    private Skills $skills;

    private Spellcasting $spellcasting;

    public function __construct(
        string $id,
        array $characterClasses,
        AbilitySkills $abilitySkills,
        Proficiencies $proficiencies,
        SavingThrows $savingThrows,
        AlignmentEnum $alignment,
        Abilities $abilities,
        string $origin,
        Levels $levels,
        Race $race,
        array $extraSkills,
        string $characterName,
        string $campaignName,
        string $playerName,
        array $languages,
    ) {
        $this->id = $id;
        $this->characterClasses = $characterClasses;
        $this->abilitySkills = $abilitySkills;
        $this->proficiencies = $proficiencies;
        $this->savingThrows = $savingThrows;
        $this->alignment = $alignment;
        $this->abilities = $abilities;
        $this->origin = $origin;
        $this->levels = $levels;
        $this->race = $race;
        $this->characterName = $characterName;
        $this->campaignName = $campaignName;
        $this->playerName = $playerName;
        $this->languages = $languages;

        $this->skills = SkillsFactory::create($this, $extraSkills);

        $this->spellcasting = new Spellcasting();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSpeed(): int
    {
        return SpeedCalculator::calculate($this->race, $this->skills);
    }

    public function getNightvision(): int
    {
        return DistanceCalculator::metersToHex($this->race->getNightvision());
    }

    public function getInitiative(): int
    {
        return InitiativeCalculator::calculate($this->abilities, $this->skills);
    }

    public function getLevels(): Levels
    {
        return $this->levels;
    }

    public function getArmorClassWithoutArmor(): int
    {
        return ArmorClassCalculator::calculate($this->abilities, $this->skills);
    }

    public function getHitDices(): array
    {
        return HitDiceCalculator::calculate($this->levels);
    }

    public function getHitPoints(): int
    {
        return HitPointsCalculator::calculate($this->abilities, $this->levels);
    }

    /**
     * @return CharacterClass[]
     */
    public function getCharacterClasses(): array
    {
        return $this->characterClasses;
    }

    public function getCharacterClassFullName(): string
    {
        $result = [];

        foreach ($this->getCharacterClasses() as $characterClass) {
            $result[] = \ucwords($characterClass->getCharacterClassEnum()->getValue());
        }

        return \implode(' - ', $result);
    }

    public function getSkills(): Skills
    {
        return $this->skills;
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

    public function getOrigin(): string
    {
        return $this->origin;
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

    public function getImmunities(): array
    {
        return [];
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

    public function getAttackCount(): int
    {
        return AttackCountCalculator::calculate($this->skills);
    }

    public function getSpellCircles(): array
    {
        return $this->spellcasting->getSpellCircles($this);
    }

    public function getSpellcastingData(): array
    {
        return $this->spellcasting->getSpellcastingData($this);
    }
}
