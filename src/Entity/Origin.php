<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\OriginRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use function array_walk;

#[ORM\Entity(repositoryClass: OriginRepository::class)]
class Origin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', nullable: false, options: ['unsigned' => false])]
    private int $id;

    #[ORM\Column(type: 'string', nullable: false, unique: true, length: 255)]
    private string $name;

    #[ORM\ManyToMany(targetEntity: Proficiency::class)]
    #[ORM\JoinTable(name: 'pivot_proficiency_to_origin')]
    #[ORM\JoinColumn(name: 'origin_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Collection $proficiencies;

    public function __construct(
        string $name,
        ?array $proficiencies = [],
    ) {
        $this->name = $name;
        $this->proficiencies = new ArrayCollection();

        array_walk(
            $proficiencies,
            fn (Proficiency $proficiency)
            => $this->proficiencies->contains($proficiency)
                ?: $this->proficiencies->add($proficiency)
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getProficiencies(): Collection
    {
        return $this->proficiencies;
    }
}
