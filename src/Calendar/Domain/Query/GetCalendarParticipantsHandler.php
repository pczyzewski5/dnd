<?php

declare(strict_types=1);

namespace Calendar\Domain\Query;

use Calendar\Domain\CalendarParticipant\CalendarParticipantRepository;

class GetCalendarParticipantsHandler
{
    private CalendarParticipantRepository $repository;

    public function __construct(CalendarParticipantRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetCalendarParticipants $query): array
    {
        return $this->repository->findByCalendarId(
            $query->getCalendar()->getId()
        );
    }
}
