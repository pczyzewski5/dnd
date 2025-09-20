<?php

declare(strict_types=1);

namespace App\Calendar\Infrastructure\Persistance\Repository;

use App\Calendar\CalendarMapper;
use App\Calendar\Infrastructure\Persistance\Entity\Calendar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class CalendarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Calendar::class);
    }

    public function getOneById(Uuid $id): Calendar
    {
        /** @var Calendar|null $entity */
        $entity = $this->find($id);

        if ($entity === null) {
            throw new \RuntimeException('Calendar not found: ' . $id->toRfc4122());
        }

        return $entity;
    }

    /**
     * @return Calendar[]
     */
    public function findAll(): array
    {
        return CalendarMapper::mapArrayToDomain(
            $this->entityManager->getRepository(Calendar::class)->findAll()
        );
    }

    public function findManyForAttendantId(Uuid $userId, int $limit = 3): array
    {
        $sql = <<<SQL
SELECT * FROM calendar c
    JOIN calendar_participant cp ON c.id = cp.calendar_id
    WHERE cp.participant_id = :userId 
    ORDER BY c.created_at DESC
    LIMIT :limit
SQL;

        $stmt = $this->getEntityManager()->getConnection()->executeQuery(
            $sql,
            ['userId' => $userId, 'limit' => $limit],
            ['userId' => Types::BINARY, 'limit' => Types::INTEGER]
        );

        $result = [];

        foreach ($stmt->fetchAllAssociative() as $item) {
            $result[] = [
                'id' => $item['id'],
                'title' => $item['title'],
                'hasAnswered' => false === empty($item['will_attend']) || false === empty($item['maybe_attend'])
            ];
        }

        return $result;
    }
}
