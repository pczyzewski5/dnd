<?php

declare(strict_types=1);

namespace App\Character;

use App\Entity\Skill as SkillEntity;

class SkillFactory
{
    public static function createFromEntity(SkillEntity $skill): Skill
    {
        return new Skill(
            $skill->getName(),
            $skill->getDescription()
        );
    }

    /**
     * @return Skill[]
     */
    public static function createManyFromEntity(array $skills): array
    {
        return array_map(
            fn (SkillEntity $skill) => self::createFromEntity($skill),
            $skills
        );
    }
}
