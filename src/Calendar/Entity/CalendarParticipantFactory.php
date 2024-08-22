<?php

declare(strict_types=1);

namespace App\Calendar\Entity;

use Symfony\Component\Uid\Uuid;

class CalendarParticipantFactory
{
    public static function create(
        Uuid $calendarId,
        Uuid $participantId,
        ?string $willAttend = null,
        ?string $maybeAttend = null,
        ?string $wontAttend = null,
    ): CalendarParticipant {
        return new CalendarParticipant(
            $calendarId,
            $participantId,
            new \DateTimeImmutable(),
            $willAttend,
            $maybeAttend,
            $wontAttend,
        );
    }
}
