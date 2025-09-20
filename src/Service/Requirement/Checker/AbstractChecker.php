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

    public function setCharacterConfig(CharacterConfigDto $characterConfigDto): self
    {
        $this->characterConfigDto = $characterConfigDto;

        return $this;
    }

    public function setRequirement(Requirement $requirement): self
    {
        $result = json_decode($requirement->getConfig(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid JSON with requirement config.');
        }

        $this->requirementConfig = $result;

        return $this;
    }

    protected function getLevelConfig(int $level, string $characterClass = null): LevelConfigDto
    {
        return current(
            array_filter(
                $this->characterConfigDto->levelConfigs,
                static function (LevelConfigDto $levelConfig) use ($level, $characterClass): bool {
                    return null === $characterClass
                        ? $level === $levelConfig->level
                        : $level === $levelConfig->level && $characterClass === $levelConfig->characterClass;
                }
            )
        );
    }

    protected function getConfigValue(string $key, bool $isRequired = true): mixed
    {
        $value = $this->requirementConfig[$key] ?? null;

        if (true === $isRequired && $value === null) {
            throw new Exception(
                sprintf('Value for: %s, not found in requirement config.', $key)
            );
        }

        return $value;
    }

    protected function getAsi(
        LevelConfigDto $levelConfig,
        string $source
    ): array {
        $result = [];

        foreach ($levelConfig->asi as $asi) {
            if ($asi->source === $source) {
                $result[$asi->ability] = ($result[$asi->ability] ?? 0) + $asi->value;
            }
        }

        return $result;
    }
}
