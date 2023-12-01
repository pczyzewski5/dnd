<?php

declare(strict_types=1);

namespace Calendar\Domain\Command;

use Calendar\Domain\CalendarParticipant\CalendarParticipantDTO;
use Calendar\Domain\CalendarParticipant\CalendarParticipantPersister;
use Calendar\Domain\CalendarParticipant\CalendarParticipantRepository;

class UpdateCalendarParticipantResponseHandler
{
    private CalendarParticipantRepository $repository;
    private CalendarParticipantPersister $persister;

    public function __construct(
        CalendarParticipantRepository $repository,
        CalendarParticipantPersister $persister
    ) {
        $this->repository = $repository;
        $this->persister = $persister;
    }

    public function handle(UpdateCalendarParticipantResponse $command): void
    {
        $originalCalendarParticipant = $this->repository->getOneById(
            $command->getCalendarId(),
            $command->getParticipantId()
        );

        $dto = new CalendarParticipantDTO();
        $dto->willAttend = $command->getWillAttendDates();
        $dto->maybeAttend = $command->getMaybeAttendDates();

        $originalCalendarParticipant->update($dto);

        $this->persister->update($originalCalendarParticipant);
    }
}
