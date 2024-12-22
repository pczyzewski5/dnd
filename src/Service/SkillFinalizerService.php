<?php

declare(strict_types=1);

namespace App\Service;

use App\Ability\NewAbilities;
use App\Entity\Skill;
use App\Service\SkillFinalizer\SkillFinalizerInterface;
use App\Service\SkillFinalizer\UnarmoredDefense;
use App\Skill\FinalizedSkill;

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
        Skill $skill,
        NewAbilities $abilities,
        array $levels,
    ): FinalizedSkill {
        foreach ($this->finalizers as $finalizer) {
            if ($finalizer->supports($skill)) {
                return $finalizer->finalize($skill, $abilities, $levels);
            }
        }

        return new FinalizedSkill($skill->getName(), $skill->getDescription());
    }

    public function finalizeArray(
        array $skills,
        NewAbilities $newAbilities,
        array $levels,
    ): array {
        // description będzie jak w kartach z tego edytora, czyli będzie to jakiś kod tego edytora,
        // nie robić żadnego mappera do twigów itd
        return array_map(
            fn (Skill $skill): FinalizedSkill => $this->finalize($skill, $newAbilities, $levels),
            $skills
        );
    }
}
