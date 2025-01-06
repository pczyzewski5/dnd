<?php

declare(strict_types=1);

namespace App\Service\Requirement\Checker;

use App\Entity\Requirement;
use App\Exception\RequirementException;

use function array_intersect;

class FightingStyle extends AbstractChecker
{
    public function supports(Requirement $requirement): bool
    {
        return 'fighting style' === $requirement->getName();
    }

    public function check(): void
    {
        $errorMessage = $this->getConfigValue('error_message');
        $level = $this->getConfigValue('level');
        $class = $this->getConfigValue('class');
        $pool = $this->getConfigValue('pool');

        $chosen = array_intersect(
            $this->getClassLevelConfig($level, $class)->skills,
            $pool
        );

        if (count($chosen) !== 1) {
            throw RequirementException::requirementNotMet($errorMessage);
        }
    }
}
