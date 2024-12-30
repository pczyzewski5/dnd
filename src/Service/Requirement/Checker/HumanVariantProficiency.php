<?php

declare(strict_types=1);

namespace App\Service\Requirement\Checker;

use App\Dto\CharacterConfigDto;
use App\Entity\Requirement;
use App\Exception\RequirementException;

class HumanVariantProficiency extends AbstractChecker
{
    public function supports(Requirement $requirement): bool
    {
        return 'human_variant_proficiency' === $requirement->getName();
    }

    public function check(
        Requirement $requirement,
        CharacterConfigDto $configDto
    ): void {
        $count = count(
            $this->getFirstLevelProficienciesBySource($configDto, 'race')
        );

        if ($count !== 1) {
            throw RequirementException::requirementNotMet(
                'Human Variant race require proficiency in exactly one ability skill.'
            );
        }
    }
}
