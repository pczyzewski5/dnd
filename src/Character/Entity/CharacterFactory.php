<?php

declare(strict_types=1);

namespace App\Character\Entity;

use App\Ability\AbilitiesFactory;
use App\AbilitySkills\AbilitySkillsFactory;
use App\Character\Entity\Character as DomainCharacter;
use App\CharacterClass\CharacterClassCollectionFactory;
use App\DND\Character\Character;
use App\Enum\AlignmentEnum;
use App\Kernel;
use App\Level\LevelsFactory;
use App\Proficiency\ProficienciesFactory;
use App\Race\RaceFactory;
use App\SavingThrows\SavingThrowsFactory;

class CharacterFactory
{
    public static function createFromEntity(Character $entity): DomainCharacter
    {
        // @todo please refactor me
        $data = \json_decode($entity->data, true);

        if (\array_key_exists('input_filename', $data)) {
            $data = \file_get_contents(Kernel::getProjectDirectory() . '/input/' . $data['input_filename']);
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

        return new DomainCharacter(
            $entity->id,
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
     * @return DomainCharacter[]
     */
    public static function createManyFromEntities(array $entities): array
    {
        return \array_map(
            static fn (Character $entity) => self::createFromEntity($entity),
            $entities
        );
    }
}
