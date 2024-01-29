<?php

declare(strict_types=1);

namespace DND\Infrastructure\Character;

use App\Kernel;
use DND\Domain\Ability\AbilitiesFactory;
use DND\Domain\AbilitySkills\AbilitySkillsFactory;
use DND\Domain\CharacterClass\CharacterClassFactory;
use DND\Domain\Enum\AlignmentEnum;
use DND\Domain\Character\Character as DomainCharacter;
use DND\Domain\Level\LevelsFactory;
use DND\Domain\Proficiency\ProficienciesFactory;
use DND\Domain\Race\RaceFactory;
use DND\Domain\SavingThrows\SavingThrowsFactory;

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
        $characterClasses = CharacterClassFactory::createFromLevels($levels);

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
