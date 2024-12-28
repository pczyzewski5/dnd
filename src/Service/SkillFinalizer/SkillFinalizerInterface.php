<?php

declare(strict_types=1);

namespace App\Service\SkillFinalizer;

use App\Character\Abilities;
use App\Entity\Skill as SkillEntity;
use App\Character\Skill;

interface SkillFinalizerInterface
{
    public function supports(Skill $skill): bool;

    public function finalize(
        Abilities $abilities,
        Skill $skill,
        int $level
    ): Skill;
}
