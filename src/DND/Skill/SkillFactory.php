<?php

namespace DND\Skill;


class SkillFactory
{
    /**
     * @return Skill[]
     */
    public static function createManyWithLevels(array $data): array
    {
        $result = [];

        foreach ($data as $level => $skills) {
            foreach ($skills as $skill) {
                $result[] = new Skill($skill, $level);
            }
        }

        return $result;
    }

    public static function createManyOnlyNames(array $data): array
    {
        $result = [];

        foreach ($data as $skill) {
            $result[] = new Skill($skill);
        }

        return $result;
    }
}
