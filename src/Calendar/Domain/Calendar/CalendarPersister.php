<?php

namespace Calendar\Domain\Calendar;

use Calendar\Domain\Exception\PersisterException;

interface CalendarPersister
{
    /**
     * @throws PersisterException
     */
    public function save(Calendar $entity): void;

    /**
     * @throws PersisterException
     */
    public function update(Calendar $entity): void;

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void;
}
