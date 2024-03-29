<?php

declare(strict_types=1);

namespace Calendar\Domain\Command;

class UpdateCalendarParticipantResponse
{
    private string $calendarId;
    private string $participantId;
    private ?array $willAttendDates;
    private ?array $maybeAttendDates;
    private ?array $wontAttendDates;

    public function __construct(
        string $calendarId,
        string $participantId,
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

    public function getCalendarId(): string
    {
        return $this->calendarId;
    }

    public function getParticipantId(): string
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
