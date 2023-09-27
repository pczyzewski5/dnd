<?php

namespace DND\Domain\SavingThrows;

class SavingThrows
{
    private SavingThrow $str;
    private SavingThrow $dex;
    private SavingThrow $con;
    private SavingThrow $int;
    private SavingThrow $wis;
    private SavingThrow $cha;

    public function __construct()
    {
        $this->str = new SavingThrow();
        $this->dex = new SavingThrow();
        $this->con = new SavingThrow();
        $this->int = new SavingThrow();
        $this->wis = new SavingThrow();
        $this->cha = new SavingThrow();
    }

    public function getStr(): SavingThrow
    {
        return $this->str;
    }

    public function getDex(): SavingThrow
    {
        return $this->dex;
    }

    public function getCon(): SavingThrow
    {
        return $this->con;
    }

    public function getInt(): SavingThrow
    {
        return $this->int;
    }

    public function getWis(): SavingThrow
    {
        return $this->wis;
    }
    public function getCha(): SavingThrow
    {
        return $this->cha;
    }

    public function toArray(): array
    {
        return [
            'str' => $this->str,
            'dex' => $this->dex,
            'con' => $this->con,
            'int' => $this->int,
            'wis' => $this->wis,
            'cha' => $this->cha,
        ];
    }
}