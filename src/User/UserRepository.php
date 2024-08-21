<?php

declare(strict_types=1);

namespace App\User;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Exception\UserNotFoundException;
use App\User\Entity\User;

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
