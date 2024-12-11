<?php

namespace App\Skill\Entity;

use App\Monster\MonsterRepository;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping;

#[Mapping\Entity(repositoryClass: MonsterRepository::class)]
class Skill
{
    #[Mapping\Id]
    #[Mapping\Column(type: 'uuid', length: 36, nullable: false)]
    #[Mapping\CustomIdGenerator(class: Uuid::class)]
    private Uuid $id;

    #[Mapping\Column(type: 'string', length: 72, nullable: false)]
    private string $name;

    #[Mapping\Column(type: 'text', nullable: false)]
    private string $description;

    #[Mapping\Column(type: 'boolean', nullable: false, options: ['default' => false])]
    private bool $isCompleted;

    #[Mapping\Column(type: 'datetime_immutable', nullable: false)]
    private \DateTimeImmutable $createdAt;

    public function __construct(string $name, string $description)
    {
        $this->id = Uuid::v1();
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Skill
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Skill
    {
        $this->description = $description;
        return $this;
    }

    public function isCompleted(): bool
    {
        return $this->isCompleted;
    }

    public function setIsCompleted(bool $isCompleted): Skill
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
