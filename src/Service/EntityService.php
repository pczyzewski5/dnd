<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Uid\Uuid;

class EntityService
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function getByUuid(Uuid $uuid, string $entityClass): object
    {
        return $this->entityManager->getReference($entityClass, $uuid);
    }

    public function findAll(string $entityClass): array
    {
        return $this->entityManager->getRepository($entityClass)->findAll();
    }

    public function persist(object $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function deleteByUuid(Uuid $uuid, string $entityClass): void
    {
        $entity = $this->entityManager->getReference($entityClass, $uuid);

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }


}
