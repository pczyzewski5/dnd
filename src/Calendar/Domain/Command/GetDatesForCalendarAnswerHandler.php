<?php

declare(strict_types=1);

namespace Calendar\Domain\Command;

class GetDatesForCalendarAnswerHandler
{
    public function handle(GetDatesForCalendarAnswer $command): array
    {
        $dates = $command->getCalendar()->getDates();

       \usort($dates, function (\DateTimeImmutable $first, \DateTimeImmutable $second) {
           return $first > $second ? 1 : -1;
       });

        return $dates;
    }
}
