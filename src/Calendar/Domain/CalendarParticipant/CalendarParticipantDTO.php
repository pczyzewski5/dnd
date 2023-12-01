<?php

declare(strict_types=1);

namespace Calendar\Domain\CalendarParticipant;

class CalendarParticipantDTO
{
    public ?string $calendarId = null;
    public ?string $participantId = null;
    public ?string $data = null;
    public ?\DateTimeImmutable $createdAt = null;
}
