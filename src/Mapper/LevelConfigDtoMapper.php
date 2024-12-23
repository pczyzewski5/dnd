<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\LevelConfigDto;

use Symfony\Component\Validator\Validator\ValidatorInterface;

use function array_map;

class LevelConfigDtoMapper extends AbstractMapper
{
    public function __construct(
        private readonly AbilityConfigDtoMapper $abilityConfigDtoMapper,
        private readonly ValidatorInterface $validator
    ) {
        parent::__construct($this->validator);
    }

    public function fromArray(array $data): LevelConfigDto
    {
        $dto = new LevelConfigDto(
            $this->getValueOrNull($data, 'level'),
            $this->getValueOrNull($data, 'class'),
            $this->getValueOrNull($data, 'proficiencies'),
            $this->getValueOrNull($data, 'skills'),
            $this->abilityConfigDtoMapper->manyFromArray(
                $this->getArray($data, 'asi')
            )
        );

        $this->validate($dto);

        return $dto;
    }

    public function manyFromArray(array $data): array
    {
        return array_map(
            fn (array $datum): LevelConfigDto => $this->fromArray($datum),
            $data
        );
    }
}
