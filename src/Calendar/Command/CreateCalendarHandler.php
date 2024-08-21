<?php

declare(strict_types=1);

namespace App\Calendar\Command;

use App\Calendar\Calendar\CalendarPersister;
use App\Calendar\Calendar\Entity\CalendarFactory;

class CreateCalendarHandler
{
    private CalendarPersister $persister;

    public function __construct(CalendarPersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(CreateCalendar $command): string
    {
        $calendar = CalendarFactory::create(
            $command->getTitle(),
            false,
            $command->getOwnerId(),
            $command->getDates()
        );

        $this->persister->save($calendar);

        return $calendar->getId();
    }
}
