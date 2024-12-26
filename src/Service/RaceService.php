<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Race;
use App\Race\RaceConfig;
use App\Mapper\AbilityConfigDtoMapper;

use function json_decode;
use function json_last_error;

class RaceService
{
    public function __construct(
        private readonly AbilityConfigDtoMapper $abilityConfigDtoMapper
    ) {

    }

    public function getRaceConfig(Race $race): RaceConfig
    {
       $config = $this->decodeJson($race->getConfig());

        return new RaceConfig(
            $this->getAsi($config),
            $config['languages'],
            $config['speed_in_meters'],
            $config['darkvision_in_meters']
        );
    }

    private function decodeJson(string $json): array
    {
        $result = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // @todo changeme
            throw new \Exception('Invalid json in race config json');
        }

        return $result;
    }

    private function getAsi(array $config): array
    {
        return $this->abilityConfigDtoMapper->manyFromArray($config['asi'] ?? []);
    }
}
