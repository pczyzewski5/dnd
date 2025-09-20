<?php

declare(strict_types=1);

namespace App\Calendar\Infrastructure\Persistance\Persister;

use App\Calendar\Exception\PersisterException;
use App\Calendar\Infrastructure\Persistance\Entity\Calendar as DomainEntity;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;

class CalendarPersister
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

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void
    {
        try {
            $this->entityManager->getConnection()->executeQuery(
                'DELETE FROM calendar WHERE id = ?',
                [$id],
                [Types::STRING]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }
}
