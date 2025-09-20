<?php

declare(strict_types=1);

namespace App\PlayerCharacter\Entity;

use App\PlayerCharacter\Repository\PlayerCharacterRepository;
use Doctrine\ORM\Mapping;
use Symfony\Component\Uid\Uuid;

#[Mapping\Entity(repositoryClass: PlayerCharacterRepository::class)]
class PlayerCharacter
{
    #[Mapping\Id]
    #[Mapping\Column(type: 'uuid', length: 36, nullable: false)]
    #[Mapping\CustomIdGenerator(class: Uuid::class)]
    private Uuid $id;

    #[Mapping\Column(type: 'text', nullable: false)]
    private string $data;

    #[Mapping\Column(type: 'uuid', length: 36, nullable: false)]
    private string $ownerId;

    #[Mapping\Column(type: 'datetime_immutable', nullable: false)]
    private \DateTimeImmutable $createdAt;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getIdAsString(): string
    {
        return $this->id->toRfc4122();
    }

    public function setId(Uuid $id): PlayerCharacter
    {
        $this->id = $id;

        return $this;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function setData(string $data): PlayerCharacter
    {
        $this->data = $data;

        return $this;
    }

    public function getOwnerId(): string
    {
        return $this->ownerId;
    }

    public function setOwnerId(string $ownerId): PlayerCharacter
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): PlayerCharacter
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
