<?php

declare(strict_types=1);

namespace App\Calendar\Application\Command;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;

class CreateCalendarParticipants
{
    public function __construct(
        private readonly Uuid $calendarId,
        private readonly array $participants
    ) {
    }

    public function getCalendarId(): Uuid
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
