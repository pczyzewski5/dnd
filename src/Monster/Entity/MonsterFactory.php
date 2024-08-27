<?php

declare(strict_types=1);

namespace App\Monster\Entity;

class MonsterFactory
{
    public static function create(
        string $name,
        int $armorClass,
        int $maxHp,
        int $speed,
        string $image,
    ): Monster {
        return new Monster(
            $name,
            $armorClass,
            $maxHp,
            $speed,
            $image,
        );
    }
}
