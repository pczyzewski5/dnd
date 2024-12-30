<?php

declare(strict_types=1);

namespace App\Builder;

use App\Calculator\HitDiceCalculator;
use App\Calculator\ProficiencyBonusCalculator;
use App\Calculator\SimpleLevelsCalculator;
use App\Character\Levels;
use App\Character\Proficiencies;
use App\Character\SkillFactory;
use App\Character\Skills;
use App\Dto\LevelConfigDto;
use App\Dto\ProficiencyDto;
use App\Entity\Level;
use App\Repository\LevelRepository;
use App\Repository\ProficiencyRepository;
use App\Repository\SkillRepository;
use App\Character\Skill;

use function array_map;
use function array_merge;
use function count;
use function var_dump;

class LevelsBuilder
{
    private array $levelConfigDtos;

    public function __construct(
        private readonly LevelRepository $levelRepository,
        private readonly ProficiencyRepository $proficiencyRepository,
        private readonly SkillRepository $skillRepository,
        private readonly ProficiencyBonusCalculator $proficiencyBonusCalculator,
        private readonly HitDiceCalculator $hitDiceCalculator,
        private readonly SimpleLevelsCalculator $simpleLevelsCalculator,
    ) {
    }

    public function setLevelConfigs(array $dtos): self
    {
        $this->levelConfigDtos = array_map(
            fn (LevelConfigDto $dto) => $dto,
            $dtos
        );

        return $this;
    }

    public function build(): Levels
    {
        $levels = $this->getLevels($this->levelConfigDtos);
        $skills = $this->getSkills($levels, $this->levelConfigDtos);
        $proficiencies = $this->getProficiencies($levels, $this->levelConfigDtos);
        $proficiencyBonus = $this->proficiencyBonusCalculator->calculate(count($levels));
        $simpleLevels = $this->simpleLevelsCalculator->calculate($levels);
        $hitDices = $this->hitDiceCalculator->calculate($levels);

        return new Levels(
            $proficiencies,
            $proficiencyBonus,
            $levels,
            $hitDices,
            $simpleLevels,
            $skills
        );
    }

    private function getLevels(array $levelConfigDtos): array
    {
        return array_map(
            fn (LevelConfigDto $dto): Level => $this->levelRepository
                ->getByLevelAndCharacterClass(
                    $dto->level,
                    $dto->class
                ),
            $levelConfigDtos
        );
    }

    private function getProficiencies(
        array $levels,
        array $levelConfigDtos
    ): Proficiencies {
        $proficiencies = [];

        foreach ($levels as $level) {
            $proficiencies = array_merge(
                $level->getProficiencies()->toArray(),
                $proficiencies
            );
        }

        foreach ($levelConfigDtos as $dto) {
            $names = array_map(
                fn (ProficiencyDto $dto) => $dto->name,
                $dto->proficiencies
            );

            $proficiencies = array_merge(
                $this->proficiencyRepository->getByNames($names),
                $proficiencies
            );
        }

        return new Proficiencies(...$proficiencies);
    }

    private function getSkills(
        array $levels,
        array $levelConfigDtos
    ): Skills {
        $skills = [];

        foreach ($levels as $level) {
            $skills = array_merge(
                SkillFactory::createManyFromEntity(
                    $level->getSkills()->toArray()
                ),
                $skills
            );
        }

        foreach ($levelConfigDtos as $dto) {
            $skills = array_merge(
                SkillFactory::createManyFromEntity(
                    $this->skillRepository->getByNames($dto->skills)
                ),
                $skills
            );
        }

        return new Skills(...$skills);
    }
}
