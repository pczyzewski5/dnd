<?php

namespace DND\Skill\Skills;

use DND\Character\Character;
use DND\Domain\Enum\SkillTagEnum;
use DND\Skill\Skill;

class DivineSense extends AbstractSkill
{
    protected int $count = 1;
    protected array $tags = [
        SkillTagEnum::ACTIVE,
        SkillTagEnum::USE_COUNT,
    ];

    public function __construct(Character $character, Skill $skill)
    {
        parent::__construct($character, $skill);

        $this->count = $this->character->getAbilities()->getCha()->getModifier() + 1;
    }

    public function getContext(): array
    {
        return [];
    }
}
