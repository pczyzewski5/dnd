<?php

declare(strict_types=1);

namespace App\Calendar\Domain\Model;

class CalendarParticipant
{
    public ?string $calendarId;
    public ?string $participantId;
    public ?string $willAttend;
    public ?string $maybeAttend;
    public ?string $wontAttend;
    public ?\DateTime $createdAt;
}
