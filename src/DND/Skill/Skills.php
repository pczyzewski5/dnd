<?php

namespace DND\Skill;

use App\CaseConverter;
use DND\Character\Character;
use DND\Skill\Skills\AbstractSkill;

class Skills
{
    private const SKILLS_NAMESPACE = 'DND\Skill\Skills\\';

    private array $skills;

    public function addSkills(array $skills): void
    {
       \array_walk($skills,[$this, 'addSkill']);
    }

    /**
     * @return AbstractSkill[]
     */
    public function getSkills(Character $character): array
    {
        $result = [];

        foreach (\range(0, $character->getActualLevel()) as $level) {
            foreach ($this->skills[$level] ?? [] as $skill) {
                $result[] = new ($this->getSkillClass($skill))($character);
            }
        }

        return $result;
    }

    private function addSkill(Skill $skill): void
    {
        if (false === \class_exists($this->getSkillClass($skill))) {
            // @todo changeme
            throw new \Exception('Skill: ' . $skill->getName() . ', has no implementation.');
        }

        $this->skills[$skill->getLevel() ?? 0][] = $skill;
    }

    private function getSkillClass(Skill $skill): string
    {
        return self::SKILLS_NAMESPACE . CaseConverter::normalToUpperCamel($skill->getName());
    }
}
