<?php

declare(strict_types=1);

namespace App\User;

use DND\Domain\Exception\PersisterException;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserPersister implements PasswordUpgraderInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(User $entity): void
    {
        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    public function update(User $user): void
    {
        try {
            $sql = 'UPDATE user
                  SET is_active = :isActive
                  WHERE id = :id;';

            $this->entityManager->getConnection()->executeQuery(
                $sql,
                [
                    'id' => $user->getId(),
                    'isActive' => $user->isActive(),
                ],
                [
                    'id' => Types::STRING,
                    'isActive' => Types::BOOLEAN,
                ]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    public function delete(User $user): void
    {
        try {
            $this->entityManager->getConnection()->executeQuery(
                'DELETE FROM users WHERE id = ?',
                [$user->getId()],
                [Types::STRING]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    public function upgradePassword(
        UserInterface|PasswordAuthenticatedUserInterface $user,
        string $newHashedPassword
    ): void {
        throw new \Exception('not implemented');
    }
}
