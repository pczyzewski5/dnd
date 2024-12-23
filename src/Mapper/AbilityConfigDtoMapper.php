<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\AbilityConfigDto;

use function array_map;

class AbilityConfigDtoMapper extends AbstractMapper
{
    public function fromArray(array $data): AbilityConfigDto
    {
        $dto = new AbilityConfigDto(
            $this->getValueOrNull($data, 'ability'),
            $this->getValueOrNull($data, 'value'),
        );

        $this->validate($dto);

        return $dto;
    }

    public function manyFromArray(array $data): array
    {
        return array_map(
            fn (array $datum): AbilityConfigDto => $this->fromArray($datum),
            $data
        );
    }
}
