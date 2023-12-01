<?php

namespace Calendar\Domain\CalendarParticipant;

use Calendar\Domain\Exception\PersisterException;

interface CalendarParticipantPersister
{
    /**
     * @throws PersisterException
     */
    public function save(CalendarParticipant $entity): void;

    /**
     * @throws PersisterException
     */
    public function update(CalendarParticipant $entity): void;

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void;
}
