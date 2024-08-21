<?php

declare(strict_types=1);

namespace App\Calendar\Query;

use App\Calendar\Calendar\CalendarRepository;

class GetCalendarsForUserHandler
{
    private CalendarRepository $repository;

    public function __construct(CalendarRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetCalendarsForUser $query): array
    {
        return $this->repository->findManyForAttendantId($query->getUser()->getId());
    }
}
