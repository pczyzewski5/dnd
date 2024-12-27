<?php

declare(strict_types=1);

namespace App\Builder;

use App\Character\Abilities;
use App\Character\Proficiencies;
use App\Character\SavingThrow;
use App\Enum\AbilityEnum;

use function array_map;
use function in_array;

class SavingThrowsBuilder
{
    private array $proficiencies;
    private int $proficiencyBonus;
    private Abilities $abilities;

    public function setProficiencies(Proficiencies $proficiencies): self
    {
        $this->proficiencies = $proficiencies->getSavingThrowProficiencies();

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
            function (AbilityEnum $abilityEnum) {
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

                return new SavingThrow(
                    $abilityEnum,
                    $value,
                    $hasProficiency
                );
            },
            AbilityEnum::cases()
        );
    }
}