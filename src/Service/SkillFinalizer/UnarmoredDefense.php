<?php

declare(strict_types=1);

namespace App\Service\SkillFinalizer;

use App\Ability\NewAbilities;
use App\Entity\Skill;
use App\Skill\FinalizedSkill;

use function sprintf;

class UnarmoredDefense implements SkillFinalizerInterface
{
    public function supports(Skill $skill): bool
    {
        return $skill->getName() === 'unarmored defense';
    }

    public function finalize(
        NewAbilities $abilities,
        Skill $skill,
        int $level,
    ): FinalizedSkill {
        return new FinalizedSkill(
            $skill->getName(),
            sprintf(
                $skill->getDescription(),
                10 + $abilities->dex->modifier + $abilities->con->modifier
            )
        );
    }
}
