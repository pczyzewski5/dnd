<?php

declare(strict_types=1);

namespace Calendar\Domain\Query;

use Calendar\Domain\Calendar\Calendar;

class GetCalendarParticipants
{
    private Calendar $calendar;

    public function __construct(Calendar $calendar)
    {
        $this->calendar = $calendar;
    }

    public function getCalendar(): Calendar
    {
        return $this->calendar;
    }
}
