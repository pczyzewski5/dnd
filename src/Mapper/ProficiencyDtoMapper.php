<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\ProficiencyDto;

use function array_map;

class ProficiencyDtoMapper extends AbstractMapper
{
    public function fromArray(array $data): ProficiencyDto
    {
        $dto = new ProficiencyDto(
            $this->getValueOrNull($data, 'name'),
            $this->getValueOrNull($data, 'source'),
        );

        $this->validate($dto);

        return $dto;
    }

    public function manyFromArray(array $data): array
    {
        return array_map(
            fn (array $datum): ProficiencyDto => $this->fromArray($datum),
            $data
        );
    }
}
