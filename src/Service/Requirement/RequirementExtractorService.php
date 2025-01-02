<?php

declare(strict_types=1);

namespace App\Service\Requirement;

use App\Dto\CharacterConfigDto;
use App\Dto\LevelConfigDto;
use App\Repository\RequirementRepository;

use function array_merge;
use function crc32;

class RequirementExtractorService
{
    public function __construct(
        private readonly RequirementRepository $repository
    ) {

    }

    public function extract(CharacterConfigDto $dto): array
    {
        $result = [];

        $requirements = array_merge(
            $this->getRaceRequirements($dto),
            $this->getCharacterClassRequirements($dto),
        );

        foreach ($requirements as $requirement) {
            $key = crc32($requirement->getConfig() . $requirement->getId());

            $result[$key] = $requirement;
        }

        return $result;
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
