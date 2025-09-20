<?php

namespace App\Calendar\Domain\Repository;

use App\Calendar\Domain\Model\Calendar;
use App\Calendar\Exception\PersisterException;

interface CalendarPersister
{
    /**
     * @throws PersisterException
     */
    public function save(Calendar $domainEntity): void;

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void;
}
