<?php

declare(strict_types=1);

namespace Calendar\Domain\Command;

use Calendar\Domain\Calendar\Calendar;

class GetDatesForCalendar
{
    private ?Calendar $calendar;

    public function __construct(?Calendar $calendar = null)
    {
        $this->calendar = $calendar;
    }

    public function getCalendar(): ?string
    {
        return null === $this->calendar
            ? null
            : $this->calendar->getCreatedAt()->format('Y-m-01');
    }
}
