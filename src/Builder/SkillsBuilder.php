<?php

declare(strict_types=1);

namespace App\Builder;

use App\Builder\SkillBuilder\BelQuathSong;
use App\Builder\SkillBuilder\FeatLucky;
use App\Builder\SkillBuilder\Rage;
use App\Builder\SkillBuilder\AbstractSkillFinisher;
use App\Character\Abilities;
use App\Character\SkillFactory;
use App\Character\Skills;
use App\Dto\CharacterConfigDto;
use App\Entity\Level;
use App\Character\Skill;
use App\Entity\Race;
use App\Repository\SkillRepository;

use function array_map;
use function array_merge;
use function count;

class SkillsBuilder
{
    private CharacterConfigDto $characterConfigDto;

    private Abilities $abilities;

    /** @var Level[] */
    private array $levels;

    private Race $race;

    /** @var AbstractSkillFinisher */
    private array $finishers = [];

    public function __construct(public readonly SkillRepository $skillRepository)
    {
        $this->finishers = [
            new Rage(),
            new FeatLucky(),
            new BelQuathSong()
        ];
    }

    public function setCharacterConfigDto(CharacterConfigDto $config): self
    {
        $this->characterConfigDto = $config;

        return $this;
    }

    public function setAbilities(Abilities $abilities): self
    {
        $this->abilities = $abilities;

        return $this;
    }

    public function setLevels(array $levels): self
    {
        $this->levels = $levels;

        return $this;
    }

    public function setRace(Race $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getSkillEntities(): array
    {
        $result = [];

        foreach ($this->levels as $level) {
            $result = array_merge(
                $level->getSkills()->toArray(),
                $result
            );
        }

        foreach ($this->characterConfigDto->levelConfigs as $dto) {
            $result = array_merge(
                $this->skillRepository->getByNames($dto->skills),
                $result
            );

            $feat = $dto->feat;

            if (null === $feat) {
                continue;
            }

            $result[] = $this->skillRepository->getByName($feat->name);
        }

        $result = array_merge(
            $this->race->getSkills()->toArray(),
            $result
        );

        return $result;
    }

    public function finishSkills(
        array $skills,
        array $skillIndex,
        int $level
    ): array {
        $finish = function (Skill $skill) use ($skillIndex, $level): Skill {
            foreach ($this->finishers as $finisher) {
                if ($finisher->supports($skill)) {
                    $skill = $finisher->setup(
                        $this->abilities,
                        $skillIndex,
                        $level
                    )->finish($skill);
                }
            }

            return $skill;
        };

        return array_map($finish, $skills);
    }


    public function build(): Skills
    {
        $skills = $this->getSkillEntities();
        $skills = SkillFactory::createManyFromEntities($skills);

        $skillIndex = array_map(
            fn (Skill $skill): string => $skill->name,
            $skills
        );

        $skills = $this->finishSkills(
            $skills,
            $skillIndex,
            count($this->levels),
        );

        return new Skills(...$skills);
    }
}
