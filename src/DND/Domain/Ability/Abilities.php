<?php

declare(strict_types=1);

namespace DND\Domain\Ability;

use DND\Domain\Enum\AbilityEnum;

class Abilities
{
    private Ability $str;
    private Ability $dex;
    private Ability $con;
    private Ability $int;
    private Ability $wis;
    private Ability $cha;

    public function __construct(
        Ability $str,
        Ability $dex,
        Ability $con,
        Ability $int,
        Ability $wis,
        Ability $cha
    ) {
        $this->str = $str;
        $this->dex = $dex;
        $this->con = $con;
        $this->int = $int;
        $this->wis = $wis;
        $this->cha = $cha;
    }

    public function getStr(): Ability
    {
        return $this->str;
    }

    public function getDex(): Ability
    {
        return $this->dex;
    }

    public function getCon(): Ability
    {
        return $this->con;
    }

    public function getInt(): Ability
    {
        return $this->int;
    }

    public function getWis(): Ability
    {
        return $this->wis;
    }

    public function getCha(): Ability
    {
        return $this->cha;
    }

    public function toArray(): array
    {
        return [
            AbilityEnum::STR => $this->str,
            AbilityEnum::DEX => $this->dex,
            AbilityEnum::CON => $this->con,
            AbilityEnum::INT => $this->int,
            AbilityEnum::WIS => $this->wis,
            AbilityEnum::CHA => $this->cha,
        ];
    }
}
