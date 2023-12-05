<?php

declare(strict_types=1);

namespace Calendar\Domain\Query;

use Calendar\Domain\Calendar\Calendar;
use Calendar\Domain\Calendar\CalendarRepository;

class GetCalendarHandler
{
    private CalendarRepository $repository;

    public function __construct(CalendarRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GetCalendar $query): Calendar
    {
        return $this->repository->getOneById($query->getId());
    }
}
