<?php

declare(strict_types=1);

namespace App\Builder\SkillBuilder;

use App\Character\Skill;
use App\Character\SkillFactory;

class SneakAttack extends AbstractSkillFinisher
{
    private const SNEAK_ATTACK_DICE_COUNT = [
        1 => 1,
        2 => 1,
        3 => 2,
        4 => 2,
        5 => 3,
        6 => 3,
        7 => 4,
        8 => 4,
    ];

    public function supports(Skill $skill): bool
    {
        return 'sneak attack' === $skill->name;
    }

    public function finish(Skill $skill): Skill
    {
        $level = $this->getLevel('assassin') + $this->getLevel('rouge');
        $count = self::SNEAK_ATTACK_DICE_COUNT[$level];

        $description = $this->replacePlaceholders(
            ['sneakAttackDiceCount' => $count],
            $skill->description
        );

        return SkillFactory::create(
            $skill->name,
            $description
        );
    }
}
