<?php

declare(strict_types=1);

namespace DND\Domain\Skill;

use DND\Domain\Enum\SkillTagEnum;
use DND\Domain\Skill\Skills\AbstractSkill;

class Skills
{
    private array $skills;

    public function addSkill(AbstractSkill $skill): void
    {
        foreach ($skill->getTags() as $tag) {
            $this->skills[$tag][] = $skill;
            $this->skills['index'][] = \get_class($skill);
        }
    }

    public function hasSkill(string $name): bool
    {
        return \in_array($name, $this->skills['index']);
    }

    /**
     * @return AbstractSkill[]
     */
    public function getActiveSkills(): array
    {
        return $this->getSkillsByTag(SkillTagEnum::ACTIVE());
    }

    /**
     * @return AbstractSkill[]
     */
    public function getPassiveSkills(): array
    {
        return $this->getSkillsByTag(SkillTagEnum::PASSIVE());
    }

    /**
     * @return AbstractSkill[]
     */
    public function getSkillsWithUseCount(): array
    {
        return $this->getSkillsByTag(SkillTagEnum::USE_COUNT());
    }

    /**
     * @return AbstractSkill[]
     */
    private function getSkillsByTag(SkillTagEnum $skillTagEnum): array
    {
        $result = $this->skills[$skillTagEnum->getValue()] ?? [];

        \usort($result, static function (AbstractSkill $skillA, AbstractSkill $skillB) {
            return $skillA->getOrder() > $skillB->getOrder() ? 1 : -1;
        });

        return $result;
    }
}
