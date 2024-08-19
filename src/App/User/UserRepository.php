<?php

declare(strict_types=1);

namespace App\User;

use App\Exception\UserNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getOneById(string $id): User
    {
        $entity = $this->find($id);

        if (null === $entity) {
            throw UserNotFoundException::notFound($id);
        }

        return $entity;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->findOneBy([
            'email' => $email
        ]);
    }
}
