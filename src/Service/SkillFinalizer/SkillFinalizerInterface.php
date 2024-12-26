<?php

declare(strict_types=1);

namespace App\Service\SkillFinalizer;

use App\Ability\NewAbilities;
use App\Entity\Skill;
use App\Skill\FinalizedSkill;

interface SkillFinalizerInterface
{
    public function supports(Skill $skill): bool;

    public function finalize(
        NewAbilities $abilities,
        Skill $skill,
        int $level
    ): FinalizedSkill;
}
