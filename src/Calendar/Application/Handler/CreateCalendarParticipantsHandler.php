<?php

declare(strict_types=1);

namespace App\Calendar\Application\Handler;

use App\Calendar\Application\Command\CreateCalendarParticipants;
use App\Calendar\Domain\Model\CalendarParticipantFactory;
use App\Calendar\Infrastructure\Persistance\Persister\CalendarParticipantPersister;

class CreateCalendarParticipantsHandler
{
    private CalendarParticipantPersister $persister;

    public function __construct(CalendarParticipantPersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(CreateCalendarParticipants $command): void
    {
        foreach ($command->getParticipants() as $user) {
            $itemCard = CalendarParticipantFactory::create(
                $command->getCalendarId(),
                $user->getId()
            );

            $this->persister->save($itemCard);
        }
    }
}
