<?php

declare(strict_types=1);

namespace Calendar\Domain\CalendarParticipant;

use Calendar\Domain\Exception\RepositoryException;

interface CalendarParticipantRepository
{
    /**
     * @throws RepositoryException
     */
    public function getOneById(string $id): CalendarParticipant;

    /**
     * @return CalendarParticipant[]
     */
    public function findAll(): array;
}
