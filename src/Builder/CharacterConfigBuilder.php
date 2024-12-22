<?php

declare(strict_types=1);

namespace App\Builder;

use App\Ability\AbilitiesConfig;
use App\Dto\AbilitiesConfigDto;
use App\Dto\CharacterConfigDto;
use App\Dto\LevelConfigDto;
use App\NewCharacter\CharacterConfig;
use App\Level\LevelConfig;

use function array_map;

class CharacterConfigBuilder
{
    public function build(CharacterConfigDto $dto): CharacterConfig
    {
        return new CharacterConfig(
            $dto->characterName,
            $dto->playerName,
            $dto->campaignName,
            $dto->alignment,
            $dto->race,
            $dto->origin,
            $this->getLevelConfigs($dto->levelConfigDtos),
            $this->getAbilitiesConfig($dto->abilitiesConfigDto),
        );
    }

    private function getLevelConfigs(array $dtos): array
    {
        return array_map(
            fn (LevelConfigDto $dto): LevelConfig
            => new LevelConfig(
                $dto->level,
                $dto->class,
                $dto->skills,
                $dto->proficiencies,
            ),
            $dtos
        );
    }

    private function getAbilitiesConfig(AbilitiesConfigDto $dto): AbilitiesConfig
    {
        return new AbilitiesConfig(
            $dto->str,
            $dto->dex,
            $dto->con,
            $dto->int,
            $dto->wis,
            $dto->cha,
        );
    }
}
