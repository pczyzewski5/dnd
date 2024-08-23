<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use Doctrine\ORM\Mapping\Entity;
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
        $entity = $this->getByUuid($uuid, $entityClass);

        $this->delete($entity);
    }

    public function delete(object $entity): void
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }


}
