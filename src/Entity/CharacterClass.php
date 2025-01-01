<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CharacterClassRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use function array_walk;

#[ORM\Entity(repositoryClass: CharacterClassRepository::class)]
class CharacterClass
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', nullable: false, options: ['unsigned' => false])]
    private int $id;

    #[ORM\Column(type: 'smallint', nullable: false, options: ['unsigned' => false])]
    private int $hitDice;

    #[ORM\Column(type: 'string', nullable: false, unique: true, length: 255)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?self $baseClass;

    #[ORM\ManyToMany(targetEntity: Requirement::class)]
    #[ORM\JoinTable(name: 'pivot_requirement_to_character_class')]
    #[ORM\JoinColumn(name: 'character_class_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Collection $requirements;

    public function __construct(
        int $hitDice,
        string $name,
        ?self $baseClass = null,
        ?array $requirements = []
    ) {
        $this->hitDice = $hitDice;
        $this->name = $name;
        $this->baseClass = $baseClass;
        $this->requirements = new ArrayCollection();

        array_walk(
            $requirements,
            fn (Requirement $requirement)
            => $this->requirements->contains($requirement)
                ?: $this->requirements->add($requirement)
        );
    }

    public function getHitDice(): int
    {
        return $this->hitDice;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBaseClass(): ?self
    {
        return $this->baseClass;
    }
}
