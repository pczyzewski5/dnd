<?php

declare(strict_types=1);

namespace App\User\Entity;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;

class UserFactory
{
    public static function create(
        string $email,
        string $username,
        array $roles,
        string $password,
        bool $isActive,
    ): User {
        return (new User)
            ->setId(Uuid::v1())
            ->setEmail($email)
            ->setUsername($username)
            ->setRoles($roles)
            ->setPassword($password)
            ->setIsActive($isActive)
            ->setCreatedAt(
                new \DateTimeImmutable()
            );
    }
}
