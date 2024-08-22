<?php

declare(strict_types=1);

namespace App\Calendar\Command;

use App\Calendar\Calendar\CalendarPersister;

class DeleteCalendarHandler
{
    private CalendarPersister $persister;

    public function __construct(CalendarPersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(DeleteCalendar $command): void
    {
        $this->persister->delete($command->getId());
    }
}
