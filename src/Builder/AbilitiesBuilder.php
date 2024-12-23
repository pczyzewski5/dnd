<?php

declare(strict_types=1);

namespace App\Builder;

use App\Ability\NewAbilities;
use App\Ability\NewAbilityFactory;
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

    public function build(): NewAbilities
    {
        return new NewAbilities(
            NewAbilityFactory::create(NewAbilityEnum::STR, $this->str),
            NewAbilityFactory::create(NewAbilityEnum::DEX, $this->dex),
            NewAbilityFactory::create(NewAbilityEnum::CON, $this->con),
            NewAbilityFactory::create(NewAbilityEnum::INT, $this->int),
            NewAbilityFactory::create(NewAbilityEnum::WIS, $this->wis),
            NewAbilityFactory::create(NewAbilityEnum::CHA, $this->cha),
        );
    }
}