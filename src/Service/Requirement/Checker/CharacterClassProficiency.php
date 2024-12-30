<?php

declare(strict_types=1);

namespace App\Service\Requirement\Checker;

use App\Dto\CharacterConfigDto;
use App\Entity\Requirement;
use App\Exception\RequirementException;

use function array_diff;
use function count;
use function implode;
use function sprintf;

class CharacterClassProficiency extends AbstractChecker
{
    public function supports(Requirement $requirement): bool
    {
        return 'character_class_proficiency' === $requirement->getName();
    }

    public function check(
        Requirement $requirement,
        CharacterConfigDto $configDto
    ): void {
        $config = $this->getRequirementConfig($requirement);
        $chosen = $this->getFirstLevelProficienciesBySource($configDto, 'character_class');

        $this->checkCount($chosen, $config['required_count']);
        $this->checkChosen($chosen, $config['available_proficiencies']);
    }

    private function checkCount(array $chosen, int $required): void
    {
        $actual = count($chosen);

        if ($actual !== $required) {
            throw RequirementException::requirementNotMet(
                sprintf(
                    'Character class require to pick exactly %s proficiencies. You have chosen %s.',
                    $required,
                    $actual
                )
            );
        }
    }

    private function checkChosen(array $chosen, array $available): void
    {
        if (!empty(array_diff($chosen, $available))) {
            throw RequirementException::requirementNotMet(
                sprintf(
                    'Character class require to pick proficiencies from: %s.',
                    implode(', ', $available)
                )
            );
        }
    }
}
