<?php

namespace App\Monster\Entity;

use App\Monster\MonsterRepository;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping;

#[Mapping\Entity(repositoryClass: MonsterRepository::class)]
class Monster
{
    #[Mapping\Id]
    #[Mapping\Column(type: 'uuid', length: 36, nullable: false)]
    #[Mapping\CustomIdGenerator(class: Uuid::class)]
    private Uuid $id;

    #[Mapping\Column(type: 'string', length: 72, nullable: false)]
    private string $name;

    #[Mapping\Column(type: 'integer', length: 2, nullable: false)]
    private int $armorClass;

    #[Mapping\Column(type: 'integer', length: 4, nullable: false)]
    private int $maxHp;

    #[Mapping\Column(type: 'text', nullable: false)]
    private string $image;

    #[Mapping\Column(type: 'datetime_immutable', nullable: false)]
    private \DateTimeImmutable $createdAt;

    public function __construct(string $name, int $armorClass, int $maxHp, string $image)
    {
        $this->id = Uuid::v1();
        $this->name = $name;
        $this->armorClass = $armorClass;
        $this->maxHp = $maxHp;
        $this->image = $image;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getIdAsString(): string
    {
        return $this->id->toRfc4122();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Monster
    {
        $this->name = $name;
        return $this;
    }

    public function getArmorClass(): int
    {
        return $this->armorClass;
    }

    public function setArmorClass(int $armorClass): Monster
    {
        $this->armorClass = $armorClass;
        return $this;
    }

    public function getMaxHp(): int
    {
        return $this->maxHp;
    }

    public function setMaxHp(int $maxHp): Monster
    {
        $this->maxHp = $maxHp;
        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): Monster
    {
        $this->image = $image;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): Monster
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
