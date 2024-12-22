<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\AbilitiesConfigDto;

class AbilitiesConfigDtoMapper extends AbstractMapper
{
    public function fromArray(array $data): AbilitiesConfigDto
    {
        $dto = new AbilitiesConfigDto(
            $this->getValueOrNull($data, 'str'),
            $this->getValueOrNull($data, 'dex'),
            $this->getValueOrNull($data, 'con'),
            $this->getValueOrNull($data, 'int'),
            $this->getValueOrNull($data, 'wis'),
            $this->getValueOrNull($data, 'cha')
        );

        $this->validate($dto);

        return $dto;
    }
}
