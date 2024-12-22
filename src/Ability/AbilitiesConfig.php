<?php

declare(strict_types=1);

namespace App\Ability;

class AbilitiesConfig
{
    public function __construct(
        public readonly int $str,
        public readonly int $dex,
        public readonly int $con,
        public readonly int $int,
        public readonly int $wis,
        public readonly int $cha
    ) {
    }
}
