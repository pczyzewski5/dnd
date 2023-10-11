<?php

namespace DND\Skill;

use DND\Character\Character;
use DND\Skill\Skills\AbstractSkill;

class Skills
{
    private array $skills;

    public function __construct(array $skills)
    {
        $this->skills = $skills;
    }

    /**
     * @return AbstractSkill[]
     */
    public function getSkills(Character $character): array
    {
        $result = [];

        foreach (\range(1, $character->getActualLevel()) as $level) {
            if (\array_key_exists($level, $this->skills)) {
                foreach ($this->skills[$level] as $skill) {
                    $class = 'DND\Skill\Skills\\' . \ucfirst($skill);
                    if (false === \class_exists($class)) {
                        // @todo changeme
                        throw new \Exception('Skill class: ' . $class . ', does not exists.');
                    }

                    $result[] = new $class($character);
                }
            }
        }

        return $result;
    }
}
