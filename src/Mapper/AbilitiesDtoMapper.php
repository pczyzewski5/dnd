<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\AbilitiesDto;

use function var_dump;

class AbilitiesDtoMapper extends AbstractMapper
{
    public function fromArray(array $data): AbilitiesDto
    {
        $dto = new AbilitiesDto(
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
