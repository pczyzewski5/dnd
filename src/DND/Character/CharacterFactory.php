<?php

namespace DND\Character;

use DND\CharacterClass\CharacterClassFactory;
use DND\Domain\Ability\AbilitiesFactory;
use DND\Domain\Enum\AlignmentEnum;
use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Enum\OriginEnum;
use DND\Domain\Enum\RaceEnum;
use DND\Domain\Proficiency\Proficiencies;
use DND\Domain\Proficiency\ProficienciesFactory;
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
            $data['campaign_name'],
            RaceEnum::from($data['race']),
            OriginEnum::from($data['origin']),
            AlignmentEnum::from($data['alignment']),
            LevelsFactory::fromArray($data['levels']),
            AbilitiesFactory::create($data['starting_abilities']),
            AbilitySkillsFactory::create(),
            ProficienciesFactory::create($data['proficiencies']),
            ['orczy', 'ludzki'],
            ['ogień'],
            ['woda'],
        );
    }
}
