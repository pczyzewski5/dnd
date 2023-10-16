<?php

namespace DND\Skill;

use App\CaseConverter;
use DND\Character\Character;
use DND\Domain\Enum\SkillTagEnum;
use DND\Skill\Skills\AbstractSkill;

class Skills
{
    private const SKILLS_NAMESPACE = 'DND\Skill\Skills\\';

    private array $skills;

    public function addSkill(Skill $skill): void
    {
        if (false === \class_exists($this->getSkillClass($skill))) {
           SkillFilesGenerator::generateFiles($skill);
        }

        $this->skills[$skill->getLevel() ?? 0][] = $skill;
    }

    /**
     * @return AbstractSkill[]
     */
    public function getActiveSkills(Character $character): array
    {
        return $this->getSkills($character, SkillTagEnum::ACTIVE());
    }

    /**
     * @return AbstractSkill[]
     */
    public function getPassiveSkills(Character $character): array
    {
        return $this->getSkills($character, SkillTagEnum::PASSIVE());
    }

    /**
     * @return AbstractSkill[]
     */
    public function getSkillsWithUseCount(Character $character): array
    {
        return $this->getSkills($character, SkillTagEnum::USE_COUNT());
    }

    /**
     * @return AbstractSkill[]
     */
    private function getSkills(Character $character, SkillTagEnum $skillTagEnum): array
    {
        $result = [];

        foreach (\range(0, $character->getActualLevel()) as $level) {
            foreach ($this->skills[$level] ?? [] as $skill) {
                $class = $this->getSkillClass($skill);
                $class = new $class($character, $skill);
                if ($class->hasTag($skillTagEnum)) {
                    $result[] = $class;
                }
            }
        }

        \usort($result, static function (AbstractSkill $skill, AbstractSkill $anotherSkill) {
            return $skill::ORDER > $anotherSkill::ORDER ? 1 : -1;
        });

        return $result;
    }

    private function getSkillClass(Skill $skill): string
    {
        return self::SKILLS_NAMESPACE . CaseConverter::normalToUpperCamel($skill->getName());
    }
}
