<?php

declare(strict_types=1);

namespace App\Calendar\Application\Dto;

class CalendarParticipantDto
{
    public ?string $calendarId = null;
    public ?string $participantId = null;
    public ?array $willAttend = null;
    public ?array $maybeAttend = null;
    public ?array $wontAttend = null;
    public ?\DateTimeImmutable $createdAt = null;
}
