<?php

declare(strict_types=1);

namespace App\Calendar\Application\Handler;


use App\Calendar\Application\Query\GetCalendarsForUser;
use App\Calendar\Infrastructure\Persistance\Repository\CalendarRepository;

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
