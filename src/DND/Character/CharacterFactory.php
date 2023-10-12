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
        $proficiencies = \array_merge(
            $data['proficiencies'],
            $data['expert_proficiencies'],
            $characterClass->getProficiencies()
        );
        $proficiencies = ProficienciesFactory::fromArray($proficiencies);
        $characterSubclass = CharacterClassResolver::getCharacterSubclass($levels);
        $race = RaceFactory::create(RaceEnum::from($data['race']));
        $abilities = AbilitiesFactory::fromArray($data['starting_abilities']);
        $abilities = AbilityMerger::merge($abilities, $race);
        $abilitySkills = AbilitySkillsFactory::create($abilities, $proficiencies, $levels);
        $skills = SkillsFactory::create($characterClass, $race);

        return new Character(
            $characterClass,
            $abilitySkills,
            $proficiencies,
            SavingThrowsFactory::create($abilities, $proficiencies, $levels),
            AlignmentEnum::from($data['alignment']),
            $abilities,
            OriginEnum::from($data['origin']),
            $skills,
            $levels,
            $race,
            $data['character_name'],
            $data['campaign_name'],
            $data['player_name'],
            [],
            [],
            $data['languages'],
            $characterSubclass
        );
    }
}
