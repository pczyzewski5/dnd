<?php

declare(strict_types=1);

namespace App\Service\Requirement\Checker;

use App\Dto\CharacterConfigDto;
use App\Entity\Requirement;

use function json_decode;
use function json_last_error;

abstract class AbstractChecker
{
    abstract public function supports(Requirement $requirement): bool;

    abstract public function check(
        Requirement $requirement,
        CharacterConfigDto $configDto
    ): void;

    protected function getRequirementConfig(Requirement $requirement): array
    {
        $config = json_decode($requirement->getConfig(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid JSON with requirement config.');
        }

        return $config;
    }

    protected function getFirstLevelProficienciesBySource(
        CharacterConfigDto $configDto,
        string $source //source do zmiany na enuma?
    ): array {
        $result = [];

        foreach ($configDto->levelConfigDtos as $levelConfig) {
            if ($levelConfig->level === 1) {
                foreach ($levelConfig->proficiencies as $proficiency) {
                    if ($proficiency->source === $source) {
                        $result[] =$proficiency->name;
                    }
                }
            }
        }

        return $result;
    }
}
