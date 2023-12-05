<?php

declare(strict_types=1);

namespace Calendar\Domain\Command;

class GetDatesForCalendar
{
    private ?\DateTimeImmutable $startDate;

    public function __construct(?\DateTimeImmutable $startDate = null)
    {
        $this->startDate = $startDate;
    }

    public function getStartDate(): ?string
    {
        return null === $this->startDate
            ? null
            : $this->startDate->format('Y-m-01');
    }
}
