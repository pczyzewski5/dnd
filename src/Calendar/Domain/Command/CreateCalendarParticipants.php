<?php

declare(strict_types=1);

namespace Calendar\Domain\Command;

use DND\Domain\User\User;

class CreateCalendarParticipants
{
    private string $calendarId;
    private array $participants;

    public function __construct(string $calendarId, array $participants)
    {
        $this->calendarId = $calendarId;
        $this->participants = $participants;
    }

    public function getCalendarId(): string
    {
        return $this->calendarId;
    }

    /**
     * @return User[]
     */
    public function getParticipants(): array
    {
        return $this->participants;
    }
}
