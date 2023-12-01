<?php

declare(strict_types=1);

namespace Calendar\Infrastructure\CalendarParticipant;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Calendar\Domain\CalendarParticipant\CalendarParticipantPersister as DomainPersister;
use Calendar\Domain\CalendarParticipant\CalendarParticipant as DomainEntity;
use Calendar\Domain\Exception\PersisterException;

class CalendarParticipantPersister implements DomainPersister
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws PersisterException
     */
    public function save(DomainEntity $domainEntity): void
    {
        $entity = CalendarParticipantMapper::fromDomain($domainEntity);

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    public function update(DomainEntity $domainEntity): void
    {
        $entity = CalendarParticipantMapper::fromDomain($domainEntity);

        try {
            $sql = 'UPDATE calendar_participants
                  SET will_attend = :willAttend,
                      maybe_attend = :maybeAttend
                  WHERE calendar_id = :calendarId AND participant_id = :participantId;';

            $this->entityManager->getConnection()->executeQuery(
                $sql,
                [
                    'willAttend' => $entity->willAttend,
                    'maybeAttend' => $entity->maybeAttend,
                    'calendarId' => $entity->calendarId,
                    'participantId' => $entity->participantId,
                ],
                [
                    'calendarId' => Types::STRING,
                    'participantId' => Types::STRING,
                ]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void
    {
        try {
            $this->entityManager->getConnection()->executeQuery(
                'DELETE FROM calendar_participants WHERE id = ?',
                [$id],
                [Types::STRING]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }
}
