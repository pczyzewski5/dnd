<?php

declare(strict_types=1);

namespace App\Service\Requirement\Checker;

use App\Dto\LevelConfigDto;
use App\Entity\Requirement;
use App\Exception\RequirementException;

use function count;
use function sprintf;
use function ucfirst;

class TwoDifferentAsi extends AbstractChecker
{
    public function supports(Requirement $requirement): bool
    {
        return 'two different asi' === $requirement->getName();
    }

    public function check(): void
    {
        $level = $this->getConfigValue('level');
        $source = $this->getConfigValue('source');

        $asi = $this->getAsi(
            $this->getLevelConfig($level),
            $source
        );

        $errorMsg = sprintf(
            '%s require to increase two different abilities by one point at %s level.',
            ucfirst($source),
            $level
        );

        count($asi) === 2 || throw RequirementException::requirementNotMet($errorMsg);

        foreach ($asi as $value) {
            $value === 1 ||throw RequirementException::requirementNotMet($errorMsg);
        }
    }
}
