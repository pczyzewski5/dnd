<?php

declare(strict_types=1);

namespace App\Calendar;

use App\Calendar\Calendar\Entity\Calendar as DomainEntity;
use App\Calendar\Exception\RepositoryException;
use App\Calendar\Calendar\Calendar;
use App\Calendar\Calendar\CalendarMapper;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class CalendarRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOneById(string $id): DomainEntity
    {
        $entity = $this->entityManager->getRepository(Calendar::class)->find($id);

        if (null === $entity) {
            throw RepositoryException::notFound(Calendar::class, $id);
        }

        return CalendarMapper::toDomain($entity);
    }

    /**
     * @return DomainEntity[]
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

        $stmt = $this->entityManager->getConnection()->executeQuery(
            $sql,
            ['userId' => $userId, 'limit' => $limit],
            ['userId' => Types::STRING, 'limit' => Types::INTEGER]
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
