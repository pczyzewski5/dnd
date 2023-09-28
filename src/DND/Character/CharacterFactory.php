<?php

namespace DND\Character;

use DND\Domain\Ability\AbilitiesFactory;
use DND\Domain\Enum\AlignmentEnum;
use DND\Domain\Enum\OriginEnum;
use DND\Domain\Enum\RaceEnum;
use DND\Domain\Proficiency\ProficienciesFactory;

class CharacterFactory
{
    public static function createFromArray(array $data): Character
    {
        return new Character(
            $data['character_name'],
            $data['player_name'],
            $data['campaign_name'],
            RaceEnum::from($data['race']),
            OriginEnum::from($data['origin']),
            AlignmentEnum::from($data['alignment']),
            LevelsFactory::fromArray($data['levels']),
            AbilitiesFactory::fromArray($data['starting_abilities']),
            ProficienciesFactory::fromArray($data['proficiencies']),
            ['orczy', 'ludzki'],
            ['ogień'],
            ['woda'],
        );
    }
}
