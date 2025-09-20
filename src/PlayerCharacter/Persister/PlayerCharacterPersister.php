<?php

declare(strict_types=1);

namespace App\PlayerCharacter\Persister;

use App\Exception\PersisterException;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;

class PlayerCharacterPersister
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function delete(string $id): void
    {
        try {
            $this->entityManager->getConnection()->executeQuery(
                'DELETE FROM player_character WHERE id = ?',
                [$id],
                [Types::STRING]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }
}
