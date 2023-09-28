<?php

namespace DND\Character;

use DND\CharacterClass\CharacterClassFactory;
use DND\Domain\Ability\AbilitiesFactory;
use DND\Domain\Enum\Alignment;
use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Enum\Origin;
use DND\Domain\Enum\RaceEnum;
use DND\Domain\SavingThrows\SavingThrowsFactory;
use DND\Domain\Skills\AbilitySkillsFactory;
use DND\Race\RaceFactory;

class CharacterFactory
{
    public static function createFromArray(array $data): Character
    {
        return new Character(
            $data['character_name'],
            $data['player_name'],
            RaceFactory::create(RaceEnum::from($data['race'])),
            Origin::from($data['origin']),
            Alignment::from($data['alignment']),
            new Level(),
            CharacterClassFactory::create(CharacterClassEnum::from('barbarian')),
            AbilitiesFactory::create(),
            SavingThrowsFactory::create(),
            AbilitySkillsFactory::create(),
            ['pojazdy lądowe', 'lekkie pancerze'],
            ['orczy', 'ludzki'],
            ['ogień'],
            ['woda'],
        );
    }
}
