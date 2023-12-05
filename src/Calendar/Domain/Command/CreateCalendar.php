<?php

declare(strict_types=1);

namespace Calendar\Domain\Command;

class CreateCalendar
{
    private string $title;
    private bool $isPublic;
    private string $ownerId;
    private array $dates;

    public function __construct(
        string $title,
        bool $isPublic,
        string $ownerId,
        array $dates
    ) {
        $this->title = $title;
        $this->isPublic = $isPublic;
        $this->ownerId = $ownerId;
        $this->dates = $dates;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    public function getOwnerId(): string
    {
        return $this->ownerId;
    }

    /**
     * @return \DateTimeImmutable[]
     */
    public function getDates(): array
    {
        return $this->dates;
    }
}
