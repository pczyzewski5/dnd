<?php

declare(strict_types=1);

namespace App\Service\Requirement;

use App\Dto\CharacterConfigDto;

class RequirementProcessorService
{
    public function __construct(
        private readonly RequirementExtractorService $requirementExtractor,
        private readonly RequirementCheckerService $requirementChecker,
    ) {
    }

    public function process(CharacterConfigDto $dto): void
    {
        $this->requirementChecker->check(
            $this->requirementExtractor->extract($dto),
            $dto
        );
    }
}
