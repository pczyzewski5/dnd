<?php

declare(strict_types=1);

namespace Calendar\Domain\CalendarParticipant;

class CalendarParticipantFactory
{
    public static function create(
    string $calendarId,
    string $participantId,
    ?string $willAttend = null,
    ?string $maybeAttend = null,
    ?string $wontAttend = null,
    ): CalendarParticipant {
        $dto = new CalendarParticipantDTO();
        $dto->calendarId = $calendarId;
        $dto->participantId = $participantId;
        $dto->willAttend = $willAttend;
        $dto->maybeAttend = $maybeAttend;
        $dto->wontAttend = $wontAttend;
        $dto->createdAt = new \DateTimeImmutable();

        return new CalendarParticipant($dto);
    }
}
