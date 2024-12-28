<?php

declare(strict_types=1);

namespace App\Service;

use App\Character\Abilities;
use App\Character\Skill;
use App\Character\Skills;
use App\Entity\Skill as SkillEntity;
use App\Service\SkillFinalizer\SkillFinalizerInterface;
use App\Service\SkillFinalizer\UnarmoredDefense;

use function array_map;

class SkillFinalizerService
{
    /** @var SkillFinalizerInterface */
    private array $finalizers = [];

    public function __construct(
        UnarmoredDefense $unarmoredDefense
    ) {
        $this->finalizers = [
            $unarmoredDefense,
        ];
    }

    public function finalize(
        Abilities $abilities,
        Skill $skill,
        int $level,
    ): Skill {
//        foreach ($this->finalizers as $finalizer) {
//            if ($finalizer->supports($skill)) {
//                return $finalizer->finalize($abilities, $skill, $level);
//            }
//        }
//
//        return new Skill($skill->name, $skill->getDescription());
        return $skill;
    }

    public function finalizeArray(
        Abilities $abilities,
        Skills $skills,
        int $level,
    ): array {
        // description będzie jak w kartach z tego edytora, czyli będzie to jakiś kod tego edytora,
        // nie robić żadnego mappera do twigów itd
        return array_map(
            fn (Skill $skill): Skill => $this->finalize($abilities, $skill, $level),
            $skills->toArray()
        );
    }
}
