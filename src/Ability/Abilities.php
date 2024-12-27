<?php

declare(strict_types=1);

namespace App\Ability;

use App\Enum\AbilityEnum;

use Exception;
use function get_object_vars;

class Abilities
{
    // to zmienic na array
    public function __construct(
        public readonly Ability $str,
        public readonly Ability $dex,
        public readonly Ability $con,
        public readonly Ability $int,
        public readonly Ability $wis,
        public readonly Ability $cha
    ) {
    }

    public function getByAbilityEnum(AbilityEnum $abilityEnum): Ability
    {
        foreach (get_object_vars($this) as $ability) {
            if ($ability->abilityEnum === $abilityEnum) {
                return $ability;
            }
        }

        throw new Exception('Cannot match ability.');
    }

    /**
     * @return Ability[]
     */
    public function toArray(): array
    {
        return [
            $this->str,
            $this->dex,
            $this->con,
            $this->int,
            $this->wis,
            $this->cha,
        ];
    }
}
