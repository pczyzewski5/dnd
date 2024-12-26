<?php

declare(strict_types=1);

namespace App\Builder;

use App\Ability\Abilities;
use App\Ability\AbilitySkill;
use App\Enum\NewAbilitySkillEnum;
use App\Proficiency\NewProficiencies;

use function array_map;
use function in_array;

class AbilitySkillsBuilder
{
    private array $proficiencies;
    private int $proficiencyBonus;
    private Abilities $abilities;

    public function setProficiencies(NewProficiencies $proficiencies): self
    {
        $this->proficiencies = $proficiencies->getAbilitySkillProficiencies();

        return $this;
    }

    public function setProficiencyBonus(int $proficiencyBonus): self
    {
        $this->proficiencyBonus = $proficiencyBonus;

        return $this;
    }

    public function setAbilities(Abilities $abilities): self
    {
        $this->abilities = $abilities;

        return $this;
    }

    public function build(): array
    {
        return array_map(
            function (NewAbilitySkillEnum $abilitySkillEnum) {
                $ability = $this->abilities->getByAbilityEnum(
                    $abilitySkillEnum->getAbilityEnum()
                );

                $hasProficiency = in_array(
                    $abilitySkillEnum->value,
                    $this->proficiencies
                );

                $value = $hasProficiency
                    ? $ability->modifier + $this->proficiencyBonus
                    : $ability->modifier;

                return new AbilitySkill(
                    $abilitySkillEnum,
                    $value,
                    $hasProficiency
                );
            },
            NewAbilitySkillEnum::cases()
        );
    }
}