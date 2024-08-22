<?php

declare(strict_types=1);

namespace App\Calendar\Command;

use App\Calendar\CalendarPersister;
use App\Calendar\Entity\CalendarFactory;

class CreateCalendarHandler
{
    public function __construct(private readonly CalendarPersister $persister)
    {
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
