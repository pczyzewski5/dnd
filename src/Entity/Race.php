<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\RaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RaceRepository::class)]
class Race
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', nullable: false, options: ['unsigned' => false])]
    private int $id;

    #[ORM\Column(type: 'string', nullable: false, unique: true, length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', nullable: false, unique: true, length: 510)]
    private string $config;

    #[ORM\ManyToMany(targetEntity: Requirement::class)]
    #[ORM\JoinTable(name: 'pivot_requirement_to_race')]
    #[ORM\JoinColumn(name: 'race_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Collection $requirements;

    public function __construct(
        string $name,
        string $config,
        ?array $requirements = []
    ) {
        $this->name = $name;
        $this->config = $config;
        $this->requirements = new ArrayCollection();

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

    public function getConfig(): string
    {
        return $this->config;
    }
}
