<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\AbilitiesDto;

class AbilitiesDtoMapper extends AbstractMapper
{
    public function fromArray(array $data): AbilitiesDto
    {
        $dto = new AbilitiesDto;
        $dto->str = $data['str'] ?? null;
        $dto->dex = $data['dex'] ?? null;
        $dto->con = $data['con'] ?? null;
        $dto->int = $data['int'] ?? null;
        $dto->wis = $data['wis'] ?? null;
        $dto->cha = $data['cha'] ?? null;

        $this->validate($dto);

        return $dto;
    }

}
