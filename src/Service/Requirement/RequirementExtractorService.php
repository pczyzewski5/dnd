<?php

declare(strict_types=1);

namespace App\Service\Requirement;

use App\Dto\CharacterConfigDto;
use App\Dto\LevelConfigDto;
use App\Repository\RequirementRepository;

use function array_merge;

class RequirementExtractorService
{
    public function __construct(
        private readonly RequirementRepository $repository
    ) {

    }

    public function extract(CharacterConfigDto $dto): array
    {
        return array_merge(
            $this->getLevelsRequirements($dto),
            $this->getRaceRequirements($dto)
        );
    }

    private function getLevelsRequirements(CharacterConfigDto $dto): array
    {
        $result = [];

        /** @var LevelConfigDto $configDto */
        foreach ($dto->levelConfigDtos as $configDto) {
            $requirements = $this->repository->findRequirementsByLevelAndCharacterClass(
                $configDto->level,
                $configDto->class
            );
            $result = array_merge($requirements, $result);
        }

        return $result;
    }

    private function getRaceRequirements(CharacterConfigDto $dto): array
    {
        return $this->repository->findRequirementsByRace($dto->race);
    }
}
