<?php

declare(strict_types=1);

namespace App\Calendar\Application\Handler;

use App\Calendar\Application\Command\CreateCalendar;
use App\Calendar\Domain\Model\CalendarFactory;
use App\Calendar\Infrastructure\Persistance\Persister\CalendarPersister;
use Symfony\Component\Uid\Uuid;

class CreateCalendarHandler
{
    public function __construct(private readonly CalendarPersister $persister)
    {
    }

    public function handle(CreateCalendar $command): Uuid
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
