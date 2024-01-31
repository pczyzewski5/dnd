<?php

declare(strict_types=1);

namespace DND\Domain\Skill;

use DND\Domain\Enum\SkillEnum;
use DND\Domain\Enum\SkillTagEnum;
use DND\Domain\Skill\Skills\AbstractSkill;

class Skills
{
    private array $skills;

    public function addSkill(AbstractSkill $skill): void
    {
        foreach ($skill->getTags() as $tag) {
            $this->skills[$tag][] = $skill;
            $this->skills['index'][] = SkillEnum::from($skill->getName())->getValue();
        }
    }

    public function hasSkill(SkillEnum|string $skillEnum): bool
    {
        if (\is_string($skillEnum)) {
            $skillEnum = SkillEnum::from($skillEnum);
        }

        return \in_array(
            $skillEnum->getValue(),
            $this->skills['index']
        );
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
