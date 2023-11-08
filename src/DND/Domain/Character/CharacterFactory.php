<?php

namespace DND\Domain\Character;

use DND\Domain\Ability\AbilitiesFactory;
use DND\Domain\AbilitySkills\AbilitySkillsFactory;
use DND\Domain\CharacterClass\CharacterClassFactory;
use DND\Domain\CharacterClass\CharacterClassResolver;
use DND\Domain\Enum\AlignmentEnum;
use DND\Domain\Level\LevelsFactory;
use DND\Domain\Proficiency\ProficienciesFactory;
use DND\Domain\Race\RaceFactory;
use DND\Domain\SavingThrows\SavingThrowsFactory;

class CharacterFactory
{
    public static function createFromArray(array $data): Character
    {
        $levels = LevelsFactory::fromArray($data['levels']);
        $characterClass = CharacterClassFactory::create(
            CharacterClassResolver::getCharacterClass($levels)
        );
        $characterSubclass = CharacterClassResolver::getCharacterSubclass($levels);
        if (null !== $characterSubclass) {
            $characterSubclass = CharacterClassFactory::create($characterSubclass);
        }
        $proficiencies = ProficienciesFactory::create(
            $characterClass,
            $data['proficiencies'],
            $data['expert_proficiencies'],
            $characterSubclass
        );
        $race = RaceFactory::create($data['race']);
        $abilities = AbilitiesFactory::create($race, $data['starting_abilities'], $data['asi']);
        $extraSkills = \array_merge(
            \array_map(static function(string $feat) { return 'feat ' . $feat; }, $data['feats']),
            $data['extra_skills']
        );

        return new Character(
            $characterClass,
            AbilitySkillsFactory::create($abilities, $proficiencies, $levels),
            $proficiencies,
            SavingThrowsFactory::create($abilities, $proficiencies, $levels),
            AlignmentEnum::from($data['alignment']),
            $abilities,
            $data['origin'],
            $levels,
            $race,
            $extraSkills,
            $data['character_name'],
            $data['campaign_name'],
            $data['player_name'],
            $data['languages'],
            $characterSubclass
        );
    }
}
