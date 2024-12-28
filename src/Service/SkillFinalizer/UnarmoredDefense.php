<?php

declare(strict_types=1);

namespace App\Service\SkillFinalizer;

use App\Character\Abilities;
use App\Character\Skill;
use App\Entity\Skill as SkillEntity;

use function sprintf;

class UnarmoredDefense implements SkillFinalizerInterface
{
    public function supports(Skill $skill): bool
    {
        return $skill->name === 'unarmored defense';
    }

    public function finalize(
        Abilities $abilities,
        Skill $skill,
        int $level,
    ): Skill {
        return new Skill(
            $skill->name,
            sprintf(
                $skill->description,
                10 + $abilities->dex->modifier + $abilities->con->modifier
            )
        );
    }
}
