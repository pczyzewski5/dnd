<?php

declare(strict_types=1);

namespace App\Calendar\Application\Handler;

use App\Calendar\Application\Command\DeleteCalendar;
use App\Calendar\Infrastructure\Persistance\Persister\CalendarPersister;

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
