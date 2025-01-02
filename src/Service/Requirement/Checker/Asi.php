<?php

declare(strict_types=1);

namespace App\Service\Requirement\Checker;

use App\Dto\LevelConfigDto;
use App\Entity\Requirement;
use App\Exception\RequirementException;

use function count;
use function ucfirst;

class Asi extends AbstractChecker
{
    public function supports(Requirement $requirement): bool
    {
        return 'asi' === $requirement->getName();
    }

    public function check(): void
    {
        $twoDifferent = $this->getConfigValue('two_different');
        $source = $this->getConfigValue('source');
        $level = $this->getConfigValue('level');

        $asi = $this->getAsi(
            $this->getLevelConfig($level),
            $source
        );

        $twoDifferent
            ? $this->checkTwoDifferent($asi, $source)
            : $this->checkAny($asi, $source);
    }

    private function getAsi(
        LevelConfigDto $levelConfig,
        string $source
    ): array {
        $result = [];

        foreach ($levelConfig->asi as $asi) {
            if ($asi->source === $source) {
                $result[$asi->ability] += $asi->value;
            }
        }

        return $result;
    }

    private function checkTwoDifferent(array $asi, string $source): void
    {
        $message = ucfirst($source) . ' require to increase two different abilities by one point.';

        count($asi) === 2 || throw RequirementException::requirementNotMet($message);

        foreach ($asi as $value) {
            $value === 1 ||throw RequirementException::requirementNotMet($message);
        }
    }

    private function checkAny(array $asi, string $source): void
    {
        $message = ucfirst($source) . ' require to increase two abilities by one point or one ability by two points.';

        count($asi) <= 2 || throw RequirementException::requirementNotMet($message);

        array_sum($asi) === 2 || throw RequirementException::requirementNotMet($message);

    }
}
