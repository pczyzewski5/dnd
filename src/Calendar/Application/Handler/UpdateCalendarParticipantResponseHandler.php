<?php

declare(strict_types=1);

namespace App\Calendar\Application\Handler;

use App\Calendar\Application\Command\UpdateCalendarParticipantResponse;
use App\Calendar\Dto\CalendarParticipantDTO;
use App\Calendar\Infrastructure\Persistance\Persister\CalendarParticipantPersister;
use App\Calendar\Infrastructure\Persistance\Repository\CalendarParticipantRepository;

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
        $dto->wontAttend = $command->getWontAttendDates();

//        $originalCalendarParticipant->update($dto);

        $this->persister->update($originalCalendarParticipant);
    }
}
