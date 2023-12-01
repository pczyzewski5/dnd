<?php

namespace Calendar\Domain\CalendarParticipant;

use Calendar\Domain\Exception\PersisterException;
use Calendar\Domain\CalendarParticipant\CalendarParticipant as DomainEntity;

interface CalendarParticipantPersister
{
    /**
     * @throws PersisterException
     */
    public function save(DomainEntity $domainEntity): void;

    /**
     * @throws PersisterException
     */
    public function update(DomainEntity $domainEntity): void;

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void;
}
