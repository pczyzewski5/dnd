<?php

declare(strict_types=1);

namespace App\Calendar\Command;

use Symfony\Component\Uid\Uuid;

class CreateCalendar
{
    public function __construct(
        private readonly string $title,
        private readonly Uuid $ownerId,
        private readonly array $dates
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getOwnerId(): Uuid
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
