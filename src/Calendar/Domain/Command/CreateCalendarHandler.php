<?php

declare(strict_types=1);

namespace Calendar\Domain\Command;

use Calendar\Domain\Calendar\CalendarFactory;
use Calendar\Domain\Calendar\CalendarPersister;

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
            $command->isPublic(),
            $command->getOwnerId(),
            $command->getDates()
        );

        $this->persister->save($calendar);

        return $calendar->getId();
    }
}
