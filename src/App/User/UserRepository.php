<?php

declare(strict_types=1);

namespace App\User;

use App\User\Exception\UserNotFoundException;
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
        $entity = $this->getEntityManager()->getRepository(User::class)->find($id);

        if (null === $entity) {
            throw UserNotFoundException::notFound($id);
        }

        return UserMapper::toDomain($entity);
    }

    /**
     * @return User[]
     */
    public function getManyById(array $userIds): array
    {
        $qb = $this->getEntityManager()
            ->getRepository(User::class)
            ->createQueryBuilder('u');

        $result = $qb->where('u.id IN (:userIds)')
            ->setParameter('userIds', $userIds)
            ->getQuery()
            ->getResult();

        return UserMapper::mapArrayToDomain($result);
    }

    public function findAllUsers(): array
    {
        $result = $this->getEntityManager()->getRepository(User::class)->findAll();

        return UserMapper::mapArrayToDomain($result);
    }

    public function findOneById(string $id): ?User
    {
        $entity = $this->getEntityManager()->getRepository(User::class)->find($id);

        return UserMapper::toDomain($entity) ?? null;
    }

    public function findUserByEmail(string $username): ?User
    {
        $entity = $this->getEntityManager()->getRepository(User::class)->findOneBy([
            'email' => $username
        ]);

        return null === $entity ? null : UserMapper::toDomain($entity);
    }
}
