<?php

declare(strict_types=1);

namespace App\Builder;

use App\Character\Abilities;
use App\Character\AbilitySkill;
use App\Character\Proficiencies;
use App\Enum\AbilitySkillEnum;

use function array_map;
use function in_array;

class AbilitySkillsBuilder
{
    private array $proficiencies;
    private int $proficiencyBonus;
    private Abilities $abilities;
    private array $expertises;

    public function setProficiencies(Proficiencies $proficiencies): self
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

    public function setExpertises(array $expertises): self
    {
        $this->expertises = $expertises;

        return $this;
    }

    public function build(): array
    {
        return array_map(
            function (AbilitySkillEnum $abilitySkillEnum) {
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

                $hasExpertise = in_array(
                    $abilitySkillEnum->value,
                    $this->expertises
                );

                $value = $hasExpertise
                    ? $value + $this->proficiencyBonus
                    : $value;

                return new AbilitySkill(
                    $abilitySkillEnum,
                    $value,
                    $hasProficiency
                );
            },
            AbilitySkillEnum::cases()
        );
    }
}