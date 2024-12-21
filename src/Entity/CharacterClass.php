<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CharacterClassRepository;
use Doctrine\ORM\Mapping as ORM;

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

    public function __construct(
        int $hitDice,
        string $name,
        ?self $baseClass = null
    ) {
        $this->hitDice = $hitDice;
        $this->name = $name;
        $this->baseClass = $baseClass;
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
