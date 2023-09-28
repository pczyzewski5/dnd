<?php

namespace DND\Domain\SavingThrows;

use DND\Domain\Enum\AbilityEnum;

class SavingThrows
{
    private SavingThrow $str;
    private SavingThrow $dex;
    private SavingThrow $con;
    private SavingThrow $int;
    private SavingThrow $wis;
    private SavingThrow $cha;

    public function __construct(
        SavingThrow $str,
        SavingThrow $dex,
        SavingThrow $con,
        SavingThrow $int,
        SavingThrow $wis,
        SavingThrow $cha,
    ) {
        $this->str = $str;
        $this->dex = $dex;
        $this->con = $con;
        $this->int = $int;
        $this->wis = $wis;
        $this->cha = $cha;
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