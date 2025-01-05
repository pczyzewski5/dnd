<?php

declare(strict_types=1);

namespace App\Service\Requirement\Checker;

use App\Dto\ProficiencyDto;
use App\Entity\Requirement;
use App\Exception\RequirementException;

use function array_filter;
use function count;
use function sprintf;

class Expertise extends AbstractChecker
{
    public function supports(Requirement $requirement): bool
    {
        return 'expertise' === $requirement->getName();
    }

    public function check(): void {
        $requiredCount = $this->getConfigValue('required_count');
        $level = $this->getConfigValue('level');

        $expertProficiencies = array_filter(
            $this->getLevelConfig($level)->proficiencies,
            fn (ProficiencyDto $dto): bool => $dto->isExpert === true
        );

        $this->checkCount(
            count($expertProficiencies),
            $requiredCount,
            $level
        );
    }

    private function checkCount(
        int $actualCount,
        int $requiredCount,
        int $level
    ): void {
        if ($actualCount !== $requiredCount) {
            throw RequirementException::requirementNotMet(
                sprintf(
                    'You need to pick exactly %s expert proficiencies at level %s. You have chosen %s.',
                    $requiredCount,
                    $level,
                    $actualCount
                )
            );
        }
    }
}
