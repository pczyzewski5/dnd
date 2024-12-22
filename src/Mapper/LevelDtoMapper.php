<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\LevelDto;

use function array_map;
use function var_dump;

class LevelDtoMapper extends AbstractMapper
{
    public function fromArray(array $data): LevelDto
    {
        $dto = new LevelDto(
            $this->getValueOrNull($data, 'level'),
            $this->getValueOrNull($data, 'class'),
            $this->getValueOrNull($data, 'proficiencies'),
            $this->getValueOrNull($data, 'skills'),
        );

        $this->validate($dto);

        return $dto;
    }

    public function manyFromArray(array $data): array
    {
        return array_map(
            fn (array $datum): LevelDto => $this->fromArray($datum),
            $data
        );
    }
}
