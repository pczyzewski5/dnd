<?php

declare(strict_types=1);

namespace App\Ability;

use App\Enum\NewAbilityEnum;

use Exception;
use function get_object_vars;

class NewAbilities
{
    public function __construct(
        public readonly NewAbility $str,
        public readonly NewAbility $dex,
        public readonly NewAbility $con,
        public readonly NewAbility $int,
        public readonly NewAbility $wis,
        public readonly NewAbility $cha
    ) {
    }

    public function getByAbilityEnum(NewAbilityEnum $abilityEnum): NewAbility
    {
        foreach (get_object_vars($this) as $ability) {
            if ($ability->abilityEnum === $abilityEnum) {
                return $ability;
            }
        }

        throw new Exception('Cannot match ability.');
    }

    /**
     * @return NewAbility[]
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
