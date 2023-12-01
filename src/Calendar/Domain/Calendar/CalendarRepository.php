<?php

declare(strict_types=1);

namespace Calendar\Domain\Calendar;

use Calendar\Domain\Exception\RepositoryException;

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
}
