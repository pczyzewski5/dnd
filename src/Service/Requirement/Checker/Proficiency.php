<?php

declare(strict_types=1);

namespace App\Service\Requirement\Checker;

use App\Dto\ProficiencyDto;
use App\Entity\Requirement;
use App\Exception\RequirementException;

use function array_diff;
use function array_filter;
use function array_walk;
use function count;
use function implode;
use function sprintf;
use function ucfirst;
use function var_dump;

class Proficiency extends AbstractChecker
{
    public function supports(Requirement $requirement): bool
    {
        return 'proficiency' === $requirement->getName();
    }

    public function check(): void {
        $requiredCount = $this->getConfigValue('required_count');
        $source = $this->getConfigValue('source');
        $level = $this->getConfigValue('level');
        $pool = $this->getConfigValue('pool');

        $chosen = array_filter(
            $this->getLevelConfig($level)->proficiencies,
            fn (ProficiencyDto $dto): bool => $dto->source === $source
        );
        $chosen = array_map(
            fn (ProficiencyDto $dto) => $dto->name,
            $chosen
        );

        $this->checkCount(
            $source,
            count($chosen),
            $requiredCount
        );

        $this->checkChosen(
            $source,
            $chosen,
            $pool
        );
    }

    private function checkCount(
        string $source,
        int $actualCount,
        int $requiredCount
    ): void {
        if ($actualCount !== $requiredCount) {
            throw RequirementException::requirementNotMet(
                sprintf(
                    '%s require to pick exactly %s proficiencies. You have chosen %s.',
                    ucfirst($source),
                    $requiredCount,
                    $actualCount
                )
            );
        }
    }

    private function checkChosen(
        string $source,
        array $chosen,
        array $pool
    ): void {
        if (empty($pool)) {
            return;
        }

        if (!empty(array_diff($chosen, $pool))) {
            throw RequirementException::requirementNotMet(
                sprintf(
                    '%s require to pick proficiencies from: %s.',
                    ucfirst($source),
                    implode(', ', $pool)
                )
            );
        }
    }
}
