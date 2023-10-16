<?php

namespace DND\Skill\Skills;

use DND\Character\Character;
use DND\Domain\Enum\SkillTagEnum;
use DND\Skill\Skill;

class Rage extends AbstractSkill
{
    private const RAGE_LEVELS = [
        1 => ['count' => 2, 'damage' => 2],
        2 => ['count' => 2, 'damage' => 2],
        3 => ['count' => 3, 'damage' => 2],
        4 => ['count' => 3, 'damage' => 2],
        5 => ['count' => 3, 'damage' => 2],
        6 => ['count' => 4, 'damage' => 2],
        7 => ['count' => 4, 'damage' => 2],
        8 => ['count' => 4, 'damage' => 2],
        9 => ['count' => 4, 'damage' => 3],
        10 => ['count' => 4, 'damage' => 3],
    ];

    protected array $tags = [
        SkillTagEnum::ACTIVE,
        SkillTagEnum::USE_COUNT,
    ];

    public function __construct(Character $character, Skill $skill)
    {
        parent::__construct($character, $skill);

        $this->count = self::RAGE_LEVELS[$this->character->getActualLevel()]['count'];
    }

    public function getContext(): array
    {
        return [
            'damage' => self::RAGE_LEVELS[$this->character->getActualLevel()]['damage']
        ];
    }
}
