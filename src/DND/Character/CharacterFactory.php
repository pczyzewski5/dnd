<?php

namespace DND\Character;

use DND\CharacterClass\CharacterClassResolver;
use DND\Domain\Ability\AbilitiesFactory;
use DND\Domain\Ability\AbilityMerger;
use DND\Domain\AbilitySkills\AbilitySkillsFactory;
use DND\Domain\Enum\AlignmentEnum;
use DND\Domain\Enum\OriginEnum;
use DND\Domain\Enum\RaceEnum;
use DND\Domain\Proficiency\ProficienciesFactory;
use DND\Domain\SavingThrows\SavingThrowsFactory;
use DND\Race\RaceFactory;
use DND\Skill\SkillsFactory;

class CharacterFactory
{
    public static function createFromArray(array $data): Character
    {
        $levels = LevelsFactory::fromArray($data['levels']);
        $characterClass = CharacterClassResolver::getCharacterClass($levels);
        $proficiencies = ProficienciesFactory::fromArray(
            \array_merge($data['proficiencies'], $characterClass->getProficiencies()),
            $data['expert_proficiencies']
        );
        $race = RaceFactory::create($data['race']);
        $abilities = AbilitiesFactory::create($race, $data['starting_abilities']);

        return new Character(
            $characterClass,
            AbilitySkillsFactory::create($abilities, $proficiencies, $levels),
            $proficiencies,
            SavingThrowsFactory::create($abilities, $proficiencies, $levels),
            AlignmentEnum::from($data['alignment']),
            $abilities,
            OriginEnum::from($data['origin']),
            SkillsFactory::create($characterClass, $race),
            $levels,
            $race,
            $data['character_name'],
            $data['campaign_name'],
            $data['player_name'],
            [],
            [],
            $data['languages'],
            CharacterClassResolver::getCharacterSubclass($levels)
        );
    }
}
