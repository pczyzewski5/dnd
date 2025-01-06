<?php

declare(strict_types=1);

namespace App\Service\Requirement\Checker;

use App\Dto\CharacterConfigDto;
use App\Dto\LevelConfigDto;
use App\Entity\Requirement;
use Exception;

use function array_filter;
use function current;
use function json_decode;
use function json_last_error;
use function sprintf;

abstract class AbstractChecker
{
    private CharacterConfigDto $characterConfigDto;
    private array $requirementConfig;

    abstract public function supports(Requirement $requirement): bool;

    abstract public function check(): void;

    public function setCharacterConfig(
        CharacterConfigDto $characterConfigDto
    ): self {
        $this->characterConfigDto = $characterConfigDto;

        return $this;
    }

    public function setRequirement(
        Requirement $requirement
    ): self {
        $result = json_decode($requirement->getConfig(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid JSON with requirement config.');
        }

        $this->requirementConfig = $result;

        return $this;
    }

    protected function getLevelConfig(int $level): LevelConfigDto
    {
        return current(
            array_filter(
                $this->characterConfigDto->levelConfigs,
                fn (LevelConfigDto $levelConfig): bool
                => $levelConfig->level === $level
            )
        );
    }

    protected function getClassLevelConfig(int $level, string $class): LevelConfigDto
    {
        return current(
            array_filter(
                $this->characterConfigDto->levelConfigs,
                fn (LevelConfigDto $levelConfig): bool
                => $levelConfig->level === $level && $levelConfig->class === $class
            )
        );
    }

    protected function getConfigValue(string $key): string|array|bool|int
    {
        if (array_key_exists($key, $this->requirementConfig)) {
            return $this->requirementConfig[$key];
        }

        throw new Exception(
            sprintf('Value for: %s, not found in requirement config.', $key)
        );
    }
}
