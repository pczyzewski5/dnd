<?php

declare(strict_types=1);

namespace Calendar\Domain\Command;

class CreateCalendar
{
    private string $title;
    private string $ownerId;
    private array $dates;

    public function __construct(
        string $title,
        string $ownerId,
        array $dates
    ) {
        $this->title = $title;
        $this->ownerId = $ownerId;
        $this->dates = $dates;
    }

    public function getTitle(): string
    {
        return $this->title;
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
