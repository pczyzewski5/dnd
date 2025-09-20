<?php

declare(strict_types=1);

namespace App\Builder;

use App\Builder\SkillBuilder\BelQuathSong;
use App\Builder\SkillBuilder\FeatLucky;
use App\Builder\SkillBuilder\FontOfMagic;
use App\Builder\SkillBuilder\IntimidatingPresence;
use App\Builder\SkillBuilder\MysticWisdom;
use App\Builder\SkillBuilder\Rage;
use App\Builder\SkillBuilder\AbstractSkillFinisher;
use App\Builder\SkillBuilder\SecondWind;
use App\Builder\SkillBuilder\SneakAttack;
use App\Builder\SkillBuilder\TidesOfChaos;
use App\Builder\SkillBuilder\WrathOfTheStorm;
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

    private int $proficiencyBonus;

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
            new BelQuathSong(),
            new SneakAttack(),
            new IntimidatingPresence(),
            new FontOfMagic(),
            new MysticWisdom(),
            new TidesOfChaos(),
            new WrathOfTheStorm(),
            new SecondWind()
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

    public function setProficiencyBonus(int $proficiencyBonus): self
    {
        $this->proficiencyBonus = $proficiencyBonus;

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
        array $levels
    ): array {
        $finish = function (Skill $skill) use ($skillIndex, $levels): Skill {
            foreach ($this->finishers as $finisher) {
                if ($finisher->supports($skill)) {
                    $skill = $finisher->setup(
                        $this->abilities,
                        $this->proficiencyBonus,
                        $skillIndex,
                        $levels
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
            $this->levels,
        );

        return new Skills(...$skills);
    }
}
