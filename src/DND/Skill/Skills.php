<?php

namespace DND\Skill;

use DND\Domain\Enum\SkillTagEnum;
use DND\Skill\Skills\AbstractSkill;

class Skills
{
    private array $skills;

    public function addSkill(AbstractSkill $skill): void
    {
        foreach ($skill->getTags() as $tag) {
            $this->skills[$tag][$skill->getGrantLevel()][] = $skill;
        }
    }

    /**
     * @return AbstractSkill[]
     */
    public function getActiveSkills(int $actualLevel): array
    {
        return $this->getSkills(SkillTagEnum::ACTIVE(), $actualLevel);
    }

    /**
     * @return AbstractSkill[]
     */
    public function getPassiveSkills(int $actualLevel): array
    {
        return $this->getSkills(SkillTagEnum::PASSIVE(), $actualLevel);
    }

    /**
     * @return AbstractSkill[]
     */
    public function getSkillsWithUseCount(int $actualLevel): array
    {
        return $this->getSkills(SkillTagEnum::USE_COUNT(), $actualLevel);
    }

    /**
     * @return AbstractSkill[]
     */
    private function getSkills(SkillTagEnum $skillTagEnum, int $actualLevel): array
    {
        $result = [];

        foreach (\range(0, $actualLevel) as $level) {
            foreach ($this->skills[$skillTagEnum->getValue()][$level] ?? [] as $skill) {
                    $result[] = $skill;
            }
        }

        \usort($result, static function (AbstractSkill $skill, AbstractSkill $anotherSkill) {
            return $skill->getOrder() > $anotherSkill->getOrder() ? 1 : -1;
        });

        return $result;
    }
}
