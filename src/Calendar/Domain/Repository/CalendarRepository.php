<?php

declare(strict_types=1);

namespace App\Calendar\Domain\Repository;

use App\Calendar\Domain\Model\Calendar;
use App\Calendar\Exception\RepositoryException;

interface CalendarRepository
{
    /**
     * @throws RepositoryException
     */
    public function getOneById(string $id): Calendar;

    /**
     * @return Calendar[]
     */
    public function findAll(): array;

    public function findManyForAttendantId(string $id): array;
}
