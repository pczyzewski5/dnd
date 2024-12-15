<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CharacterClassRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterClassRepository::class)]
#[ORM\UniqueConstraint(name: 'unique_level_class', columns: ['level', 'character_class_id'])]
class Level
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', nullable: false, options: ['unsigned' => false])]
    private int $id;

    #[ORM\Column(type: 'smallint', nullable: false, options: ['unsigned' => false])]
    private int $level;

    #[ORM\ManyToOne(targetEntity: CharacterClass::class, inversedBy: 'levels')]
    #[ORM\JoinColumn(nullable: false)]
    private CharacterClass $characterClass;

    #[ORM\ManyToMany(targetEntity: Skill::class)]
    #[ORM\JoinTable(name: 'skill_to_level')]
    #[ORM\JoinColumn(name: 'level_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Collection $skills;

    public function __construct(
        int $level,
        CharacterClass $characterClass,
        ?array $skills = []
    ) {
        $this->level = $level;
        $this->characterClass = $characterClass;
        $this->skills = new ArrayCollection();

        array_walk($skills, function (Skill $skill) {
            $this->skills->contains($skill) ?: $this->skills->add($skill);
        });
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getCharacterClass(): CharacterClass
    {
        return $this->characterClass;
    }

    public function getSkills(): Collection
    {
        return $this->skills;
    }
}
