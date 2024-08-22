<?php

namespace App\Calendar\Entity;

use App\Calendar\CalendarRepository;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping;

#[Mapping\Entity(repositoryClass: CalendarRepository::class)]
class Calendar
{
    #[Mapping\Id]
    #[Mapping\Column(type: 'uuid', length: 36, nullable: false)]
    #[Mapping\CustomIdGenerator(class: Uuid::class)]
    private Uuid $id;

    #[Mapping\Column(type: 'string', length: 36, nullable: false)]
    private string $title;

    #[Mapping\Column(type: 'boolean', nullable: false, options: ['default' => false])]
    private bool $isPublic;

    #[Mapping\Column(type: 'uuid', length: 36, nullable: false)]
    private string $ownerId;

    #[Mapping\Column(type: 'text', nullable: false)]
    private array $dates;

    #[Mapping\Column(type: 'datetime_immutable', nullable: false)]
    private \DateTimeImmutable $createdAt;

    /**
     * @param string $id
     * @param string $title
     * @param bool $isPublic
     * @param string $ownerId
     * @param array $dates
     * @param \DateTimeImmutable $createdAt
     */
    public function __construct(
        Uuid $id,
        string $title,
        bool $isPublic,
        string $ownerId,
        array $dates,
        \DateTimeImmutable $createdAt
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->isPublic = $isPublic;
        $this->ownerId = $ownerId;
        $this->dates = $dates;
        $this->createdAt = $createdAt;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Calendar
    {
        $this->title = $title;
        return $this;
    }

    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): Calendar
    {
        $this->isPublic = $isPublic;
        return $this;
    }

    public function getOwnerId(): string
    {
        return $this->ownerId;
    }

    public function setOwnerId(string $ownerId): Calendar
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    public function getDates(): array
    {
        return $this->dates;
    }

    public function setDates(array $dates): Calendar
    {
        $this->dates = $dates;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): Calendar
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
