<?php

declare(strict_types=1);

namespace App\Service\SkillFinalizer;

use App\Ability\Abilities;
use App\Entity\Skill;
use App\Skill\FinalizedSkill;

interface SkillFinalizerInterface
{
    public function supports(Skill $skill): bool;

    public function finalize(
        Abilities $abilities,
        Skill $skill,
        int $level
    ): FinalizedSkill;
}
