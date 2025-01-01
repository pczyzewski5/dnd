<?php

declare(strict_types=1);

namespace App\Service\Requirement\Checker;

use App\Dto\LanguageDto;
use App\Entity\Requirement;
use App\Exception\RequirementException;

use function array_filter;
use function count;
use function sprintf;
use function ucfirst;

class Language extends AbstractChecker
{
    public function supports(Requirement $requirement): bool
    {
        return 'language' === $requirement->getName();
    }

    public function check(): void
    {
        $requiredCount = $this->getConfigValue('required_count');
        $source = $this->getConfigValue('source');
        $level = $this->getConfigValue('level');

        $count = count(
            array_filter(
                $this->getLevelConfig($level)->languages,
                fn (LanguageDto $dto) => $dto->source === $source
            )
        );

        if ($count !== $requiredCount) {
            throw RequirementException::requirementNotMet(
                sprintf(
                    '%s require to pick exactly %s language/s. You have chosen %s.',
                    ucfirst($source),
                    $requiredCount,
                    $count
                )
            );
        }
    }
}
