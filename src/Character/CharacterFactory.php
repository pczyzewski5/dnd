<?php

declare(strict_types=1);

namespace App\Character;

use App\Ability\AbilitiesFactory;
use App\AbilitySkills\AbilitySkillsFactory;
use App\PlayerCharacter\Entity\PlayerCharacter;
use App\CharacterClass\CharacterClassCollectionFactory;
use App\Enum\AlignmentEnum;
use App\Kernel;
use App\Level\LevelsFactory;
use App\Proficiency\ProficienciesFactory;
use App\Race\RaceFactory;
use App\SavingThrows\SavingThrowsFactory;

class CharacterFactory
{
    public static function createFromEntity(PlayerCharacter $entity): Character
    {
        // @todo please refactor me
        $data = \json_decode($entity->getData(), true);

        if (\array_key_exists('input_filename', $data)) {
            $data = \file_get_contents(__DIR__ . '/../../input/' . $data['input_filename']);
            $data = \json_decode($data, true);
        }

        $levels = LevelsFactory::fromArray($data['levels']);
        $characterClasses = CharacterClassCollectionFactory::createFromLevels($levels);

        $proficiencies = ProficienciesFactory::create(
            $characterClasses,
            $data['proficiencies'],
            $data['expert_proficiencies'],
        );

        $race = RaceFactory::create($data['race']);
        $abilities = AbilitiesFactory::create($race, $data['starting_abilities'], $data['asi']);
        $extraSkills = \array_merge(
            \array_map(static function (string $feat) {
                return 'feat ' . $feat;
            }, $data['feats']),
            $data['extra_skills']
        );

        return new Character(
            $entity,
            $characterClasses,
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
            $data['languages']
        );
    }

    /**
     * @return Character[]
     */
    public static function createManyFromEntities(array $entities): array
    {
        return \array_map(
            static fn (PlayerCharacter $entity) => self::createFromEntity($entity),
            $entities
        );
    }
}
