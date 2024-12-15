<?php

declare(strict_types=1);

namespace App\Ability;

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
}
