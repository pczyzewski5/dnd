<?php

declare(strict_types=1);

namespace App\Calendar\Application\Command;

use App\Calendar\Infrastructure\Persistance\Entity\Calendar;

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
