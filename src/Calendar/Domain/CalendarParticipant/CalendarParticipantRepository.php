<?php

declare(strict_types=1);

namespace Calendar\Domain\CalendarParticipant;

use Calendar\Domain\CalendarParticipant\CalendarParticipant as DomainEntity;
use Calendar\Domain\Exception\RepositoryException;

interface CalendarParticipantRepository
{
    /**
     * @throws RepositoryException
     */
    public function getOneById(string $calendarId, string $participantId): DomainEntity;

    /**
     * @return CalendarParticipant[]
     */
    public function findAll(): array;

    /**
     * @return CalendarParticipant[]
     */
    public function findByCalendarId(string $calendarId): array;
}
