<?php

declare(strict_types=1);

namespace App\Character;

class Spellcasting
{
    public readonly int $spellAttackMod;
    public readonly int $spellSaveDc;
    public readonly int $spellsKnown;

    public function __construct(string $characterName)
    {
        if ($characterName === 'Sathoris') {
            $this->spellAttackMod = 8;
            $this->spellSaveDc = 16;
            $this->spellsKnown = 11;
        }
    }
}
