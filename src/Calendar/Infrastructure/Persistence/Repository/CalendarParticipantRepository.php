<?php

declare(strict_types=1);

namespace App\Calendar\Infrastructure\Persistance\Repository;

use App\Calendar\Exception\RepositoryException;
use App\Calendar\Infrastructure\Persistance\Entity\CalendarParticipant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class CalendarParticipantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CalendarParticipant::class);
    }

    public function getOneById(Uuid $calendarId, Uuid $participantId): CalendarParticipant
    {
        $entity = $this->findOneBy([
            'calendarId' => $calendarId,
            'participantId' => $participantId,
        ]);

        if (null === $entity) {
            throw RepositoryException::notFound(CalendarParticipant::class, $participantId);
        }

        return $entity;
    }

    public function findByCalendarId(Uuid $calendarId): array
    {
        $sql = <<<SQL
SELECT u.id AS id, u.username AS username, cp.will_attend AS will_attend, cp.maybe_attend AS maybe_attend, cp.wont_attend AS wont_attend
FROM calendar_participant cp
JOIN user u ON u.id = cp.participant_id 
WHERE cp.calendar_id = :calendarId
SQL;

        $conn = $this->getEntityManager()->getConnection();
        $stmt = $conn->executeQuery(
            $sql,
            ['calendarId' => $calendarId->toBinary()],
            ['calendarId' => Types::BINARY]
        );

        return array_map(function (array $item) {
            foreach (['will_attend', 'maybe_attend', 'wont_attend'] as $key) {
                if (null !== $item[$key]) {
                    $item[$key] = json_decode($item[$key], true);
                }
            }

            return $item;
        }, $stmt->fetchAllAssociative());
    }
}
