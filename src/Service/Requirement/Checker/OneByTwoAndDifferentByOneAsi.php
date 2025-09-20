<?php

declare(strict_types=1);

namespace App\Service\Requirement\Checker;

use App\Dto\LevelConfigDto;
use App\Entity\Requirement;
use App\Exception\RequirementException;

use function count;
use function sprintf;
use function ucfirst;

class OneByTwoAndDifferentByOneAsi extends AbstractChecker
{
    public function supports(Requirement $requirement): bool
    {
        return 'one by two and different by one asi' === $requirement->getName();
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
            '%s require to increase one ability by two points and different ability by one point at %s level.',
            ucfirst($source),
            $level
        );

        count($asi) === 2 || throw RequirementException::requirementNotMet($errorMsg);

        sort($asi);

        if ($asi !== [1, 2]) {
            throw RequirementException::requirementNotMet($errorMsg);
        }
    }
}
