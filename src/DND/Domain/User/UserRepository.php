<?php

declare(strict_types=1);

namespace DND\Domain\User;

use DND\Domain\User\Exception\UserNotFoundException;

interface UserRepository
{
    /**
     * @throws UserNotFoundException
     */
    public function getOneById(string $id): User;

    /**
     * @return User[]
     */
    public function getManyById(array $userIds): array;

    /**
     * @return User[]
     */
    public function findAllUsers(): array;

    public function findOneById(string $id): ?User;

    public function findUserByEmail(string $username): ?User;
}
