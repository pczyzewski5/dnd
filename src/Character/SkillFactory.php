<?php

declare(strict_types=1);

namespace App\Character;

use App\Entity\Skill as SkillEntity;

class SkillFactory
{
    public static function create(
        string $name,
        string $description,
        ?int $usageCount = null
    ): Skill {
        return new Skill(
            $name,
            $description,
            $usageCount
        );
    }

    public static function createFromEntity(SkillEntity $skill): Skill
    {
        return new Skill(
            $skill->getName(),
            $skill->getDescription(),
        );
    }

    public static function createManyFromEntities(array $skills): array
    {
        return array_map(
            fn (SkillEntity $skill): Skill => self::createFromEntity($skill),
            $skills
        );
    }
}
