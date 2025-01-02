<?php

declare(strict_types=1);

namespace App\Service\Requirement\Checker;

use App\Entity\Requirement;
use App\Exception\RequirementException;

use function sprintf;
use function ucfirst;

class Feat extends AbstractChecker
{
    public function supports(Requirement $requirement): bool
    {
        return 'feat' === $requirement->getName();
    }

    public function check(): void
    {
        $allowAsi = $this->getConfigValue('allow_asi');
        $source = $this->getConfigValue('source');
        $level = $this->getConfigValue('level');

        $level = $this->getLevelConfig($level);
        $feat = $level->feat->source === $source
            ? $level->feat
            : null;

        if ($allowAsi === false && [] !== $level->asi) {
            throw RequirementException::requirementNotMet(
                sprintf(
                    '%s require to pick feat or ability score increase.',
                    ucfirst($source),
                )
            );
        }

        if (null === $feat) {
            throw RequirementException::requirementNotMet(
                sprintf(
                    '%s require to pick feat.',
                    ucfirst($source),
                )
            );
        }
    }
}
