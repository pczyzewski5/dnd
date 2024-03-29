<?php

declare(strict_types=1);

namespace DND\Infrastructure\User;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use DND\Domain\User\Exception\UserNotFoundException;
use DND\Domain\User\UserRepository as DomainRepository;
use DND\Domain\User\User as DomainUser;

class UserRepository extends EntityRepository implements DomainRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct(
            $entityManager,
            $entityManager->getClassMetadata(User::class)
        );
    }

    public function getOneById(string $id): DomainUser
    {
        $entity = $this->getEntityManager()->getRepository(User::class)->find($id);

        if (null === $entity) {
            throw UserNotFoundException::notFound($id);
        }

        return UserMapper::toDomain($entity);
    }

    /**
     * @return DomainUser[]
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

    public function findOneById(string $id): ?DomainUser
    {
        $entity = $this->getEntityManager()->getRepository(User::class)->find($id);

        return UserMapper::toDomain($entity) ?? null;
    }

    public function findUserByEmail(string $username): ?DomainUser
    {
        $entity = $this->getEntityManager()->getRepository(User::class)->findOneBy([
            'email' => $username
        ]);

        return null === $entity ? null : UserMapper::toDomain($entity);
    }
}
