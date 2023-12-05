<?php

declare(strict_types=1);

namespace Calendar\Infrastructure\Calendar;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Calendar\Domain\Exception\RepositoryException;
use Calendar\Domain\Calendar\Calendar as DomainEntity;
use Calendar\Domain\Calendar\CalendarRepository as DomainRepository;

class CalendarRepository implements DomainRepository
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

    public function findManyForAttendantId(string $userId, int $limit = 3): array
    {
        $sql = <<<SQL
SELECT * FROM calendars c JOIN calendar_participants cp ON c.id = cp.calendar_id WHERE cp.participant_id = :userId LIMIT :limit
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
