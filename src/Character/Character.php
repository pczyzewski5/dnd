<?php

declare(strict_types=1);

namespace App\Character;

use App\Ability\Abilities;
use App\AbilitySkills\AbilitySkills;
use App\Calculators\ArmorClassCalculator;
use App\Calculators\AttackCountCalculator;
use App\Calculators\DistanceCalculator;
use App\Calculators\HitDiceCalculator;
use App\Calculators\HitPointsCalculator;
use App\Calculators\InitiativeCalculator;
use App\Calculators\SpeedCalculator;
use App\CharacterClass\CharacterClass;
use App\CharacterClass\CharacterClassCollection;
use App\Enum\AlignmentEnum;
use App\Level\Levels;
use App\PlayerCharacter\Entity\PlayerCharacter;
use App\Proficiency\Proficiencies;
use App\Race\Race;
use App\SavingThrows\SavingThrows;
use App\Skill\Skills;
use App\Skill\SkillsFactory;
use App\Spellcasting\Spellcasting;

class Character
{
    private Skills $skills;
    private Spellcasting $spellcasting;

    public function __construct(
        private readonly PlayerCharacter $playerCharacter,
        private readonly CharacterClassCollection $characterClassCollection,
        private readonly AbilitySkills $abilitySkills,
        private readonly Proficiencies $proficiencies,
        private readonly SavingThrows $savingThrows,
        private readonly AlignmentEnum $alignment,
        private readonly Abilities $abilities,
        private readonly string $origin,
        private readonly Levels $levels,
        private readonly Race $race,
        private readonly array $extraSkills,
        private readonly string $characterName,
        private readonly string $campaignName,
        private readonly string $playerName,
        private readonly array $languages,
    ) {
        // @todo do wyciągnięcia do buildera
        $this->skills = SkillsFactory::create($this, $extraSkills);

        $this->spellcasting = new Spellcasting();
    }

    public function getPlayerCharacter(): PlayerCharacter
    {
        return $this->playerCharacter;
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
    public function getCharacterClassCollection(): CharacterClassCollection
    {
        return $this->characterClassCollection;
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
