<?php

declare(strict_types=1);

namespace App\Builder;

use App\Character\Proficiencies;
use App\Character\Skills;
use App\Dto\ProficiencyDto;
use App\Entity\Level;
use App\Entity\Origin;

use App\Repository\ProficiencyRepository;

use function array_map;
use function array_merge;
use function var_dump;

class ProficienciesBuilder
{
    private Origin $origin;
    private array $levels;
    private array $levelConfigs;
    private Skills $skills;

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

    public function setSkills(Skills $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    public function build(): Proficiencies
    {
        return new Proficiencies(
            array_merge(
                $this->getProficienciesFromLevelConfigs($this->levelConfigs),
                $this->getProficienciesFromLevels($this->levels),
                $this->getProficienciesFromOrigin($this->origin),
                $this->getProficienciesFromSkills($this->skills),
            )
        );
    }

    /**
     * It takes proficiencies from json level config.
     */
    private function getProficienciesFromLevelConfigs(array $levelConfigs): array
    {
        $result = [];

        foreach ($levelConfigs as $dto) {
            foreach ($dto->proficiencies as $proficiency) {
                $result[] = $this->proficiencyRepository->getByName(
                    $proficiency->name
                );
            }
        }

        return $result;
    }

    private function getProficienciesFromLevels(array $levels): array
    {
        $proficiencies = [];

        /** @var Level $level */
        foreach ($levels as $level) {
            $proficiencies = array_merge(
                $level->getCharacterClass()->gerProficiencies()->toArray(),
                $proficiencies
            );
        }

        return $proficiencies;
    }

    private function getProficienciesFromOrigin(Origin $origin): array
    {
        return $origin->getProficiencies()->toArray();
    }

    private function getProficienciesFromSkills(Skills $skills): array
    {
        return $this->proficiencyRepository->findBySkills(
            $skills->getSkillIndex()
        );
    }
}
