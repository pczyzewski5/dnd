<?php

declare(strict_types=1);

namespace App\Calculators;

use App\Enum\SkillEnum;
use App\Skill\Skills;

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