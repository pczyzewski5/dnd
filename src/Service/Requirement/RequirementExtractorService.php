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
            $this->getCharacterClassRequirements($dto),
            $this->getRaceRequirements($dto)
        );
    }

    private function getCharacterClassRequirements(CharacterConfigDto $dto): array
    {
        $result = [];

        /** @var LevelConfigDto $config */
        foreach ($dto->levelConfigs as $config) {
            $result = array_merge(
                $this->repository->findRequirementsByCharacterClass($config->class),
                $result
            );
        }

        return $result;
    }

    private function getRaceRequirements(CharacterConfigDto $dto): array
    {
        return $this->repository->findRequirementsByRace($dto->race);
    }
}
