<?php

declare(strict_types=1);

namespace App\Calendar\Infrastructure\Persistance\Persister;

use App\Calendar\Exception\PersisterException;
use App\Calendar\Infrastructure\Persistance\Entity\CalendarParticipant as DomainEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;

class CalendarParticipantPersister
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
        try {
            $this->entityManager->persist($domainEntity);
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    public function update(DomainEntity $domainEntity): void
    {
        $entity = $domainEntity;

//        try {
//            $sql = 'UPDATE calendar_participant
//                  SET will_attend = :willAttend,
//                      maybe_attend = :maybeAttend,
//                      wont_attend = :wontAttend
//                  WHERE calendar_id = :calendarId AND participant_id = :participantId;';
//
//            $this->entityManager->getConnection()->executeQuery(
//                $sql,
//                [
//                    'willAttend' => $entity->willAttend,
//                    'maybeAttend' => $entity->maybeAttend,
//                    'wontAttend' => $entity->wontAttend,
//                    'calendarId' => $entity->calendarId,
//                    'participantId' => $entity->participantId,
//                ],
//                [
//                    'calendarId' => Types::STRING,
//                    'participantId' => Types::STRING,
//                ]
//            );
//        } catch (\Throwable $exception) {
//            throw PersisterException::fromThrowable($exception);
//        }
    }

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void
    {
        try {
            $this->entityManager->getConnection()->executeQuery(
                'DELETE FROM calendar_participant WHERE id = ?',
                [$id],
                [Types::STRING]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }
}
