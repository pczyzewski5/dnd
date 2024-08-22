<?php

declare(strict_types=1);

namespace App\Calendar\Query;


use App\Calendar\CalendarRepository;

class GetCalendarsForUserHandler
{
    public function __construct(private readonly CalendarRepository $repository)
    {
    }

    public function handle(GetCalendarsForUser $query): array
    {
        return $this->repository->findManyForAttendantId(
            $query->getUser()->getId()
        );
    }
}
