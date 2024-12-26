<?php

declare(strict_types=1);

namespace App\Builder;

use App\Calculator\HitDiceCalculator;
use App\Calculator\ProficiencyBonusCalculator;
use App\Calculator\SimpleLevelsCalculator;
use App\Dto\LevelConfigDto;
use App\Entity\Level;
use App\Level\NewLevels;
use App\Proficiency\Proficiencies;
use App\Repository\LevelRepository;
use App\Repository\ProficiencyRepository;
use App\Repository\SkillRepository;

use function array_map;
use function array_merge;
use function count;

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

    public function setLevelConfigDtos(array $dtos): self
    {
        $this->levelConfigDtos = array_map(
            fn (LevelConfigDto $dto) => $dto,
            $dtos
        );

        return $this;
    }

    public function build(): NewLevels
    {
        $levels = $this->getLevels($this->levelConfigDtos);
        $skills = $this->getSkills($levels, $this->levelConfigDtos);
        $proficiencies = $this->getProficiencies($levels, $this->levelConfigDtos);
        $proficiencyBonus = $this->proficiencyBonusCalculator->calculate(count($levels));
        $simpleLevels = $this->simpleLevelsCalculator->calculate($levels);
        $hitDices = $this->hitDiceCalculator->newCalculate($levels);

        return new NewLevels(
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
        $proficiencies = array_merge(
            ...array_map(
                fn (Level $level): array
                => $level->getProficiencies()->toArray(),
                $levels
        ),
            ...array_map(
                fn (LevelConfigDto $dto): array
                => $this->proficiencyRepository->getByNames($dto->proficiencies),
                $levelConfigDtos
            )
        );

        return new Proficiencies(...$proficiencies);
    }

    private function getSkills(
        array $levels,
        array $levelConfigDtos
    ): array {
        return array_merge(
            ...array_map(
                fn (Level $level): array
                => $level->getSkills()->toArray(),
                $levels
        ),
            ...array_map(
                fn (LevelConfigDto $dto): array
                => $this->skillRepository->getByNames($dto->proficiencies),
                $levelConfigDtos
            )
        );
    }
}
