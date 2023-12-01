<?php

declare(strict_types=1);

namespace Calendar\Domain\Command;

class GetDatesForCalendarHandler
{
    public function handle(GetDatesForCalendar $command): array
    {
        $calendar = [];

        $startDate = new \DateTime('first day of this month');
        $finishDate = new \DateTime('last day of next month');
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($startDate, $interval, $finishDate, \DatePeriod::INCLUDE_END_DATE);

        foreach ($period as $dateTime) {
            $calendar
            [$dateTime->format('Y')]
            [$dateTime->format('M')]
            [$dateTime->format('W')]
            [$dateTime->format('D')]
                = $dateTime;
        }

        return $calendar;
    }
}
