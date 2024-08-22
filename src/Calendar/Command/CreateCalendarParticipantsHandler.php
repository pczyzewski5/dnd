<?php

declare(strict_types=1);

namespace App\Calendar\Command;

use App\Calendar\CalendarParticipantPersister;
use App\Calendar\Entity\CalendarParticipantFactory;

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
