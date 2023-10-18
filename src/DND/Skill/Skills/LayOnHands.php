<?php

namespace DND\Skill\Skills;

use DND\Character\Character;
use DND\Domain\Enum\SkillTagEnum;
use DND\Skill\Skill;

class LayOnHands extends AbstractSkill
{
    protected int $count = 1;
    protected array $tags = [
        SkillTagEnum::ACTIVE,
        SkillTagEnum::USE_COUNT,
    ];

    public function __construct(Character $character, Skill $skill)
    {
        parent::__construct($character, $skill);

        $this->count = $this->character->getActualLevel() * 5;
    }

    public function getContext(): array
    {
        return [
            'pointsCount' => $this->count
        ];
    }
}
