<?php

declare(strict_types=1);

namespace DND\Infrastructure\Character;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use DND\Domain\Character\CharacterPersister as DomainPersister;
use DND\Domain\Character\Character;
use DND\Domain\Exception\PersisterException;

class CharacterPersister implements DomainPersister
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws PersisterException
     */
    public function save(Character $character): void
    {
        throw new \Exception('not implemented');
    }

    public function update(Character $character): void
    {
        throw new \Exception('not implemented');
    }

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void
    {
        try {
            $this->entityManager->getConnection()->executeQuery(
                'DELETE FROM characters WHERE id = ?',
                [$id],
                [Types::STRING]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }
}
