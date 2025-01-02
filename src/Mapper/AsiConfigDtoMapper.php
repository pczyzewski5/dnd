<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\AsiConfigDto;

use function array_map;

class AsiConfigDtoMapper extends AbstractMapper
{
    public function fromArray(array $data): AsiConfigDto
    {
        $dto = new AsiConfigDto(
            $this->getValueOrNull($data, 'ability'),
            $this->getValueOrNull($data, 'value'),
            $this->getValueOrNull($data, 'source'),
        );

        $this->validate($dto);

        return $dto;
    }

    public function manyFromArray(array $data): array
    {
        return array_map(
            fn (array $datum): AsiConfigDto => $this->fromArray($datum),
            $data
        );
    }
}
