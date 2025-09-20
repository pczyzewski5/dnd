<?php

namespace App\Calendar\Domain\Repository;

use App\Calendar\Exception\PersisterException;
use App\Calendar\Infrastructure\Persistance\Entity\CalendarParticipant as DomainEntity;

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
