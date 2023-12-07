<?php

declare(strict_types=1);

namespace Calendar\Infrastructure\CalendarParticipant;

use Calendar\Domain\Exception\RepositoryException;
use Doctrine\DBAL\Types\Types;
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

    public function findByCalendarId(string $calendarId): array
    {
        $sql = <<<SQL
    SELECT u.id as id, u.username as username, cp.will_attend as will_attend, cp.maybe_attend as maybe_attend, cp.wont_attend as wont_attend FROM calendar_participants cp
        JOIN users u ON u.id = cp.participant_id 
        WHERE cp.calendar_id = :calendarId 
SQL;
        $stmt = $this->entityManager->getConnection()->executeQuery(
            $sql,
            ['calendarId' => $calendarId],
            ['calendarId' => Types::STRING]
        );

        return \array_map(function (array $item) {
            $item['will_attend'] = null === $item['will_attend']
                ? null
                : \json_decode($item['will_attend'], true);

            $item['maybe_attend'] = null === $item['maybe_attend']
                ? null
                : \json_decode($item['maybe_attend'], true);

            $item['wont_attend'] = null === $item['wont_attend']
                ? null
                : \json_decode($item['wont_attend'], true);

            return $item;
        }, $stmt->fetchAllAssociative());
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
