<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use function array_walk;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', nullable: false, options: ['unsigned' => false])]
    private int $id;

    #[ORM\Column(type: 'string', nullable: false, unique: true, length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', nullable: false)]
    private string $description;

    #[ORM\ManyToMany(targetEntity: Proficiency::class)]
    #[ORM\JoinTable(name: 'pivot_proficiency_to_skill')]
    #[ORM\JoinColumn(name: 'skill_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Collection $proficiencies;

    #[ORM\ManyToMany(targetEntity: Requirement::class)]
    #[ORM\JoinTable(name: 'pivot_requirement_to_skill')]
    #[ORM\JoinColumn(name: 'skill_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Collection $requirements;

    public function __construct(
        string $name,
        string $description,
        ?array $proficiencies = [],
        ?array $requirements = []
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->proficiencies = new ArrayCollection();
        $this->requirements = new ArrayCollection();

        array_walk(
            $proficiencies,
            fn (Proficiency $proficiency)
            => $this->proficiencies->contains($proficiency)
                ?: $this->proficiencies->add($proficiency)
        );
        array_walk(
            $requirements,
            fn (Requirement $requirement)
            => $this->requirements->contains($requirement)
                ?: $this->requirements->add($requirement)
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
