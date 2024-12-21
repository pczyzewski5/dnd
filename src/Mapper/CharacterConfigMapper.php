<?php

declare(strict_types=1);

namespace App\Mapper;

use App\Ability\NewAbilities;
use App\Ability\NewAbilityFactory;
use App\Calculator\HitDiceCalculator;
use App\Calculator\HitPointsCalculator;
use App\Collection\Levels;
use App\Enum\NewAbilityEnum;
use App\Enum\NewAlignmentEnum;
use App\NewCharacter\CharacterConfig;

use App\Repository\LevelRepository;

use App\Repository\OriginRepository;

use App\Repository\RaceRepository;

use function json_decode;
use function json_last_error;
use function sprintf;

class CharacterConfigMapper
{
    public function __construct(
        private readonly OriginRepository $originRepository,
        private readonly RaceRepository $raceRepository,
        private readonly LevelRepository $levelRepository,
    ) {
    }

    public function mapFromJson(string $json): CharacterConfig
    {
        // trzeba będzie przenieść wcześniej, razem z validatorem
        $data = $this->decodeJson($json);

        return new CharacterConfig(
            $data['character_name'],
            $data['player_name'],
            $data['campaign_name'],
            $this->mapAlignment($data),
            $this->mapLevels($data),
            $this->raceRepository->findOneBy(['name' => $data['race']]),
            $this->originRepository->findOneBy(['name' => $data['origin']]),
            $this->mapAbilities($data),
        );
    }

    private function decodeJson(string $json): array
    {
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid JSON with character config.');
        }

        return $data;
    }

    private function mapAlignment(array $data): string
    {
        $alignment =  NewAlignmentEnum::tryFrom($data['alignment']);

        if ($alignment === null) {
            throw new \Exception(
                sprintf('Alignment %s, does not exist.', $data['alignment'])
            );
        }

        return $alignment->value;
    }

    private function mapLevels(array $data): Levels
    {
        $collection = new Levels();

        foreach ($data['levels'] as $level => $characterClass) {
            $collection->add(
                $this->levelRepository->getByLevelAndCharacterClass(
                    $level + 1,
                    $characterClass
                )
            );
        }

        return $collection;
    }

    private function mapAbilities(array $data): NewAbilities
    {
        $abilities = [];

        foreach (NewAbilityEnum::cases() as $enum) {
            $abilities[] = NewAbilityFactory::create(
                $enum,
                $data['starting_abilities'][$enum->value]
            );
        }

        return new NewAbilities(...$abilities);
    }
}
