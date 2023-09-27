<?php

namespace DND\Domain\Ability;

class Abilities
{
    private Ability $str;
    private Ability $dex;
    private Ability $con;
    private Ability $int;
    private Ability $wis;
    private Ability $cha;

    public function __construct(
        int $str,
        int $dex,
        int $con,
        int $int,
        int $wis,
        int $cha
    ) {
        $this->str = new Ability($str);
        $this->dex = new Ability($dex);
        $this->con = new Ability($con);
        $this->int = new Ability($int);
        $this->wis = new Ability($wis);
        $this->cha = new Ability($cha);
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
            'str' => $this->str,
            'dex' => $this->dex,
            'con' => $this->con,
            'int' => $this->int,
            'wis' => $this->wis,
            'cha' => $this->cha,
        ];
    }
}