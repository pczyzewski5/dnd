<?php

declare(strict_types=1);

namespace App\Calendar\Query;

class GetCalendarHelper
{
    private string $calendarId;

    public function __construct(string $calendarId)
    {
        $this->calendarId = $calendarId;
    }

    public function getCalendarId(): string
    {
        return $this->calendarId;
    }
}
