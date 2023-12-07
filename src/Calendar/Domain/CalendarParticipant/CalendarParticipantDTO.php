<?php

declare(strict_types=1);

namespace Calendar\Domain\CalendarParticipant;

class CalendarParticipantDTO
{
    public ?string $calendarId = null;
    public ?string $participantId = null;
    public ?array $willAttend = null;
    public ?array $maybeAttend = null;
    public ?array $wontAttend = null;
    public ?\DateTimeImmutable $createdAt = null;
}
