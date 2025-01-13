<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\LevelConfigDto;

use Symfony\Component\Validator\Validator\ValidatorInterface;

use function array_map;

class LevelConfigDtoMapper extends AbstractMapper
{
    public function __construct(
        private readonly ProficiencyDtoMapper $proficiencyDtoMapper,
        private readonly AsiConfigDtoMapper $asiConfigDtoMapper,
        private readonly LanguageDtoMapper $languageDtoMapper,
        private readonly FeatDtoMapper $featDtoMapper,
        private readonly ValidatorInterface $validator
    ) {
        parent::__construct($this->validator);
    }

    public function fromArray(array $data): LevelConfigDto
    {
        $feat = $this->getValueOrNull($data, 'feat');
        $feat = empty($feat)
            ? null
            : $this->featDtoMapper->fromArray($feat);

        $dto = new LevelConfigDto(
            $this->getValueOrNull($data, 'level'),
            $this->getValueOrNull($data, 'class'),
            $feat,
            $this->proficiencyDtoMapper->manyFromArray(
                $this->getArray($data, 'proficiencies')
            ),
            $this->getValueOrNull($data, 'skills'),
            $this->asiConfigDtoMapper->manyFromArray(
                $this->getArray($data, 'asi')
            ),
            $this->getValueOrNull($data, 'expertises'),
            $this->languageDtoMapper->manyFromArray(
                $this->getArray($data, 'languages')
            ),
            $this->languageDtoMapper->manyFromArray(
                $this->getArray($data, 'cantrips')
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
