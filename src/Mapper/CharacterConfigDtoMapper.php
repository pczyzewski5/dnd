<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Dto\CharacterConfigDto;

use Symfony\Component\Validator\Validator\ValidatorInterface;

use function json_decode;
use function json_last_error;

class CharacterConfigDtoMapper extends AbstractMapper
{
    public function __construct(
        private readonly LevelConfigDtoMapper $levelConfigDtoMapper,
        private readonly AbilitiesConfigDtoMapper $abilitiesConfigDtoMapper,
        private readonly ValidatorInterface $validator
    ) {
        parent::__construct($this->validator);
    }

    public function fromJson(string $json): CharacterConfigDto
    {
        $data = $this->jsonDecode($json);

        $dto = new CharacterConfigDto(
            $this->getValueOrNull($data, 'character_name'),
            $this->getValueOrNull($data, 'player_name'),
            $this->getValueOrNull($data, 'campaign_name'),
            $this->getValueOrNull($data, 'origin'),
            $this->getValueOrNull($data, 'race'),
            $this->getValueOrNull($data, 'alignment'),
            $this->levelConfigDtoMapper->manyFromArray(
                $this->getArray($data, 'levels')
            ),
            $this->abilitiesConfigDtoMapper->fromArray(
                $this->getArray($data, 'abilities')
            )
        );

        $this->validate($dto);

        return $dto;
    }

    private function jsonDecode(string $json): array
    {
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid JSON with character config.');
        }

        return $data;
    }
}
