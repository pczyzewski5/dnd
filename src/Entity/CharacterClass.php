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
    use CollectionTrait;

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

    #[ORM\ManyToMany(targetEntity: Proficiency::class)]
    #[ORM\JoinTable(name: 'pivot_proficiency_to_character_class')]
    #[ORM\JoinColumn(name: 'character_class_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Collection $proficiencies;

    public function __construct(
        int $hitDice,
        string $name,
        ?self $baseClass = null,
        ?array $requirements = [],
        ?array $proficiencies = [],
    ) {
        $this->hitDice = $hitDice;
        $this->name = $name;
        $this->baseClass = $baseClass;
        $this->requirements = new ArrayCollection();
        $this->proficiencies = new ArrayCollection();

        $this->addToCollection($requirements, $this->requirements);
        $this->addToCollection($proficiencies, $this->proficiencies);
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
