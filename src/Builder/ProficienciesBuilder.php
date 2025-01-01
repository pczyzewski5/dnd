<?php

declare(strict_types=1);

namespace App\Builder;

use App\Character\Proficiencies;
use App\Dto\ProficiencyDto;
use App\Entity\Origin;

use App\Repository\ProficiencyRepository;

use function array_map;
use function array_merge;

class ProficienciesBuilder
{
    private Origin $origin;
    private array $levels;
    private array $levelConfigs;

    public function __construct(
        private readonly ProficiencyRepository $proficiencyRepository,
    ) {
    }

    public function setOrigin(Origin $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function setLevels(array $levels): self
    {
        $this->levels = $levels;

        return $this;
    }

    public function setLevelConfigs(array $configs): self
    {
        $this->levelConfigs = $configs;

        return $this;
    }

    public function build(): Proficiencies
    {
        return new Proficiencies(
            array_merge(
                $this->getProficienciesFromLevels($this->levels),
                $this->getProficienciesFromOrigin($this->origin),
                $this->getProficienciesFromLevelConfigs($this->levelConfigs),
            )
        );
    }

    private function getProficienciesFromLevels(array $levels): array
    {
        $proficiencies = [];

        foreach ($levels as $level) {
            $proficiencies = array_merge(
                $level->getProficiencies()->toArray(),
                $proficiencies
            );
        }

        return $proficiencies;
    }

    private function getProficienciesFromOrigin(Origin $origin): array
    {
        return $origin->getProficiencies()->toArray();
    }

    private function getProficienciesFromLevelConfigs(array $levelConfigs): array
    {
        $result = [];

        foreach ($levelConfigs as $dto) {
            $names = array_map(
                fn (ProficiencyDto $dto) => $dto->name,
                $dto->proficiencies
            );

            $result = array_merge(
                $this->proficiencyRepository->getByNames($names),
                $result
            );
        }

        return $result;
    }
}