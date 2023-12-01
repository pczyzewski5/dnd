<?php

declare(strict_types=1);

namespace Calendar\Infrastructure\CalendarParticipant;

class CalendarParticipant
{
    public ?string $calendarId;
    public ?string $participantId;
    public ?string $data;
    public ?\DateTime $createdAt;
}
