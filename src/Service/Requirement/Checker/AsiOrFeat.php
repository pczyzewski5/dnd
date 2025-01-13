<?php

declare(strict_types=1);

namespace App\Service\Requirement\Checker;

use App\Entity\Requirement;
use App\Exception\RequirementException;

use function sprintf;
use function ucfirst;
use function var_dump;

class AsiOrFeat extends AbstractChecker
{
    public function supports(Requirement $requirement): bool
    {
        return 'asi or feat' === $requirement->getName();
    }

    public function check(): void
    {
        $source = $this->getConfigValue('source');
        $level = $this->getConfigValue('level');

        $level = $this->getLevelConfig($level);
        $feat = $level->feat->source === $source
            ? $level->feat
            : null;

        if ($feat === null && [] === $level->asi) {
            throw RequirementException::requirementNotMet(
                sprintf(
                    'MOVE ME TO CONFIG  %s require to pick feat or ability score increase.',
                    ucfirst($source),
                )
            );
        }
    }
}
