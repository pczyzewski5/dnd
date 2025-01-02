<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\FeatDto;

class FeatDtoMapper extends AbstractMapper
{
    public function fromArray(array $data): FeatDto
    {
        $dto = new FeatDto(
            $this->getValueOrNull($data, 'name'),
            $this->getValueOrNull($data, 'source'),
        );

        $this->validate($dto);

        return $dto;
    }
}
