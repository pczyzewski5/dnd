<?php

declare(strict_types=1);

namespace DND\Domain\Calculators;

use DND\Domain\Enum\SkillEnum;
use DND\Domain\Skill\Skills;

class AttackCountCalculator
{
    public static function calculate(Skills $skills): int
    {
        $count = 1;

        if ($skills->hasSkill(SkillEnum::BONUS_ATTACK)) {
            $count += 1;
        }

        return $count;
    }
}