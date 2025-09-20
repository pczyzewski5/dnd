<?php

declare(strict_types=1);

namespace App\Calendar\Application\Query;

use Symfony\Component\Uid\Uuid;

class GetCalendarHelper
{
    private Uuid $calendarId;

    public function __construct(Uuid $calendarId)
    {
        $this->calendarId = $calendarId;
    }

    public function getCalendarId(): Uuid
    {
        return $this->calendarId;
    }
}
