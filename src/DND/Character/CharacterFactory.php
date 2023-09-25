<?php

namespace DND\Character;

use DND\Domain\Enum\Alignment;
use DND\Domain\Enum\Origin;
use DND\Domain\Enum\Race;

class CharacterFactory
{
    public static function createFromArray(array $data): Character
    {
        return new Character(
            $data['character_name'],
            $data['player_name'],
            Race::from($data['race']),
            Origin::from($data['origin']),
            Alignment::from($data['alignment']),
            new Level()
        );
    }
}
