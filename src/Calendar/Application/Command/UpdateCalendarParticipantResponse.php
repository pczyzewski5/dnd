<?php

declare(strict_types=1);

namespace App\Calendar\Application\Command;

use Symfony\Component\Uid\Uuid;

class UpdateCalendarParticipantResponse
{
    private Uuid $calendarId;
    private Uuid $participantId;
    private ?array $willAttendDates;
    private ?array $maybeAttendDates;
    private ?array $wontAttendDates;

    public function __construct(
        Uuid $calendarId,
        Uuid $participantId,
        ?array $willAttendDates = null,
        ?array $maybeAttendDates = null,
        ?array $wontAttendDates = null
    ) {
        $this->calendarId = $calendarId;
        $this->participantId = $participantId;
        $this->willAttendDates = $willAttendDates;
        $this->maybeAttendDates = $maybeAttendDates;
        $this->wontAttendDates = $wontAttendDates;
    }

    public function getCalendarId(): Uuid
    {
        return $this->calendarId;
    }

    public function getParticipantId(): Uuid
    {
        return $this->participantId;
    }

    public function getWillAttendDates(): ?array
    {
        return $this->willAttendDates;
    }

    public function getMaybeAttendDates(): ?array
    {
        return $this->maybeAttendDates;
    }

    public function getWontAttendDates(): ?array
    {
        return $this->wontAttendDates;
    }
}
