<?php

declare(strict_types=1);

namespace App\Builder;

use App\Ability\Abilities;
use App\Ability\AbilityFactory;
use App\Dto\AbilityConfigDto;
use App\Enum\AbilityEnum;

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
            AbilityFactory::create(AbilityEnum::STR, $this->str),
            AbilityFactory::create(AbilityEnum::DEX, $this->dex),
            AbilityFactory::create(AbilityEnum::CON, $this->con),
            AbilityFactory::create(AbilityEnum::INT, $this->int),
            AbilityFactory::create(AbilityEnum::WIS, $this->wis),
            AbilityFactory::create(AbilityEnum::CHA, $this->cha),
        );
    }
}