<?php

declare(strict_types=1);

namespace App\Calendar\Domain\Repository;

use App\Calendar\Domain\Model\CalendarParticipant;
use App\Calendar\Exception\RepositoryException;
use App\Calendar\Infrastructure\Persistance\Entity\CalendarParticipant as DomainEntity;

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

    public function findByCalendarId(string $calendarId): array;
}
