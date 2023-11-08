<?php

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
use DND\Domain\Resistances\ResistancesMapper;
use DND\Domain\SavingThrows\SavingThrows;
use DND\Domain\Skill\SkillsFactory;
use DND\Domain\Spellcasting\Spellcasting;

class Character
{
    private CharacterClass $characterClass;
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
    private ?CharacterClass $characterSubclass;

    private int $actualLevel;

    private array $activeSkills;
    private array $passiveSkills;
    private array $resistanceSkills;
    private array $skillsWithUseCount;

    private Spellcasting $spellcasting;

    public function __construct(
        CharacterClass $characterClass,
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
        ?CharacterClass $characterSubclass
    ) {
        $this->characterClass = $characterClass;
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
        $this->characterSubclass = $characterSubclass;

        $this->actualLevel = \count($this->levels->getLevels());

        $skills = SkillsFactory::create($this, $extraSkills);
        $this->activeSkills = $skills->getActiveSkills($this->actualLevel);
        $this->passiveSkills = $skills->getPassiveSkills($this->actualLevel);
        $this->resistanceSkills = $skills->getResistanceSkills($this->actualLevel);
        $this->skillsWithUseCount = $skills->getSkillsWithUseCount($this->actualLevel);

        $this->spellcasting = new Spellcasting();
    }

    public function getSpeed(): int
    {
        return SpeedCalculator::calculate($this->race, $this->passiveSkills);
    }

    public function getNightvision(): int
    {
        return DistanceCalculator::metersToHex($this->race->getNightvision());
    }

    public function getInitiative(): int
    {
        return InitiativeCalculator::calculate($this->abilities, $this->passiveSkills);
    }

    public function getArmorClassWithoutArmor(): int
    {
        return ArmorClassCalculator::calculate($this->abilities, $this->passiveSkills);
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

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function getActiveSkills(): array
    {
        return $this->activeSkills;
    }

    public function getPassiveSkills(): array
    {
        return $this->passiveSkills;
    }

    public function getSkillsWithUseCount(): array
    {
        return $this->skillsWithUseCount;
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
        return ResistancesMapper::getResistances($this->resistanceSkills);
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

    public function getActualLevel(): int
    {
        return $this->actualLevel;
    }

    public function getAttackCount(): int
    {
        return AttackCountCalculator::calculate($this->passiveSkills);
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
