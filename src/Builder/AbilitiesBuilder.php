<?php

declare(strict_types=1);

namespace App\Builder;

use App\Ability\Abilities;
use App\Ability\AbilityFactory;
use App\Dto\AbilityConfigDto;
use App\Enum\NewAbilityEnum;

class AbilitiesBuilder
{
    private int $str = 0;
    private int $dex = 0;
    private int $con = 0;
    private int $int = 0;
    private int $wis = 0;
    private int $cha = 0;

    public function add(AbilityConfigDto ...$dto): self
    {
        foreach ($dto as $item) {
            $ability = $item->ability;

            $this->$ability += $item->value;
        }
        
        return $this;
    }

    public function build(): Abilities
    {
        return new Abilities(
            AbilityFactory::create(NewAbilityEnum::STR, $this->str),
            AbilityFactory::create(NewAbilityEnum::DEX, $this->dex),
            AbilityFactory::create(NewAbilityEnum::CON, $this->con),
            AbilityFactory::create(NewAbilityEnum::INT, $this->int),
            AbilityFactory::create(NewAbilityEnum::WIS, $this->wis),
            AbilityFactory::create(NewAbilityEnum::CHA, $this->cha),
        );
    }
}