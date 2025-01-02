<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\LanguageDto;

use function array_map;

class LanguageDtoMapper extends AbstractMapper
{
    public function fromArray(array $data): LanguageDto
    {
        $dto = new LanguageDto(
            $this->getValueOrNull($data, 'name'),
            $this->getValueOrNull($data, 'source'),
        );

        $this->validate($dto);

        return $dto;
    }

    public function manyFromArray(array $data): array
    {
        return array_map(
            fn (array $datum): LanguageDto => $this->fromArray($datum),
            $data
        );
    }
}
