<?php

declare(strict_types=1);

namespace App\Service\Requirement\Checker;

use App\Entity\Requirement;
use App\Exception\RequirementException;

use function array_filter;
use function count;
use function sprintf;
use function ucfirst;

class WizardCantrip extends AbstractChecker
{
    public function supports(Requirement $requirement): bool
    {
        return 'wizard cantrip' === $requirement->getName();
    }

    public function check(): void
    {
        $requiredCount = $this->getConfigValue('required_count');
        $source = $this->getConfigValue('source');
        $level = $this->getConfigValue('level');

        $count = count(
            array_filter(
                $this->getLevelConfig($level)->cantrips,
                fn (array $data) => $data['source'] ?? '' === $source
            )
        );

        if ($count !== $requiredCount) {
            throw RequirementException::requirementNotMet(
                sprintf(
                    '%s require to pick exactly %s wizard cantrip. You have chosen %s.',
                    ucfirst($source),
                    $requiredCount,
                    $count
                )
            );
        }
    }
}
