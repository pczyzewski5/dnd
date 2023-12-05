<?php

declare(strict_types=1);

namespace Calendar\Infrastructure\CalendarParticipant;

use Calendar\Domain\Exception\RepositoryException;
use Doctrine\ORM\EntityManagerInterface;
use Calendar\Domain\CalendarParticipant\CalendarParticipant as DomainEntity;
use Calendar\Domain\CalendarParticipant\CalendarParticipantRepository as DomainRepository;

class CalendarParticipantRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOneById(string $calendarId, string $participantId): DomainEntity
    {
        $entity = $this->entityManager->getRepository(CalendarParticipant::class)->findOneBy([
            'calendarId' => $calendarId,
            'participantId' => $participantId
        ]);

        if (null === $entity) {
            throw RepositoryException::notFound(CalendarParticipant::class, $participantId);
        }

        return CalendarParticipantMapper::toDomain($entity);
    }

    /**
     * @return DomainEntity[]
     */
    public function findByCalendarId(string $calendarId): array
    {
        $result = $this->entityManager->getRepository(CalendarParticipant::class)->findBy([
            'calendarId' => $calendarId,
        ]);

        return CalendarParticipantMapper::mapArrayToDomain($result);
    }

    /**
     * @return DomainEntity[]
     */
    public function findAll(): array
    {
        return CalendarParticipantMapper::mapArrayToDomain(
            $this->entityManager->getRepository(CalendarParticipant::class)->findAll()
        );
    }
}
