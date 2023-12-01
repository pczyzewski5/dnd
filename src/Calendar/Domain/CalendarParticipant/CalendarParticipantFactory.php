<?php

declare(strict_types=1);

namespace Calendar\Domain\CalendarParticipant;

class CalendarParticipantFactory
{
    public static function create(
    string $calendarId,
    string $participantId,
    string $data,
    ): CalendarParticipant {
        $dto = new CalendarParticipantDTO();
        $dto->calendarId = $calendarId;
        $dto->participantId = $participantId;
        $dto->data = $data;
        $dto->createdAt = new \DateTimeImmutable();

        return new CalendarParticipant($dto);
    }
}
