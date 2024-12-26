<?php

declare(strict_types=1);

namespace App\Builder;

use App\Ability\NewAbilities;
use App\Ability\NewAbilitySkill;
use App\Enum\NewAbilityEnum;
use App\Enum\NewAbilitySkillEnum;
use App\Proficiency\NewProficiencies;

use App\SavingThrows\NewSavingThrow;

use function array_map;
use function in_array;

class SavingThrowsBuilder
{
    private array $proficiencies;
    private int $proficiencyBonus;
    private NewAbilities $abilities;

    public function setProficiencies(NewProficiencies $proficiencies): self
    {
        $this->proficiencies = $proficiencies->getSavingThrowProficiencies();

        return $this;
    }

    public function setProficiencyBonus(int $proficiencyBonus): self
    {
        $this->proficiencyBonus = $proficiencyBonus;

        return $this;
    }

    public function setAbilities(NewAbilities $abilities): self
    {
        $this->abilities = $abilities;

        return $this;
    }

    public function build(): array
    {
        return array_map(
            function (NewAbilityEnum $abilityEnum) {
                $ability = $this->abilities->getByAbilityEnum(
                    $abilityEnum
                );

                $hasProficiency = in_array(
                    $abilityEnum->value,
                    $this->proficiencies
                );

                $value = $hasProficiency
                    ? $ability->modifier + $this->proficiencyBonus
                    : $ability->modifier;

                return new NewSavingThrow(
                    $abilityEnum,
                    $value,
                    $hasProficiency
                );
            },
            NewAbilityEnum::cases()
        );
    }
}