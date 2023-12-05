<?php

declare(strict_types=1);

namespace Calendar\Domain\Command;

class GetDatesForCalendarAnswerHandler
{
    public function handle(GetDatesForCalendarAnswer $command): array
    {
        $calendar = [];

        /** @var \DateTimeImmutable $dateTime */
        foreach ($command->getCalendar()->getDates() as $dateTime) {
            $calendar
            [$dateTime->format('Y')]
            [$dateTime->format('M')]
            [$dateTime->format('D')]
                = $dateTime;
        }

        return $calendar;
    }
}
