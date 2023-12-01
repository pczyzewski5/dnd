<?php

declare(strict_types=1);

namespace Calendar\Domain\Command;

use Calendar\Domain\CalendarParticipant\CalendarParticipantFactory;
use Calendar\Domain\CalendarParticipant\CalendarParticipantPersister;

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
