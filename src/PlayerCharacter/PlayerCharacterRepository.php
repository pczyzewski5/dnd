<?php

declare(strict_types=1);

namespace App\PlayerCharacter;

use App\PlayerCharacter\Entity\PlayerCharacter;
use App\Exception\RepositoryException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class PlayerCharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayerCharacter::class);
    }

    public function getOneById(Uuid $id): PlayerCharacter
    {
        $entity = $this->find($id);

        if (null === $entity) {
            throw RepositoryException::notFound(PlayerCharacter::class, $id);
        }

        return $entity;
    }

    /**
     * @return PlayerCharacter[]
     */
    public function findByOwner(Uuid $ownerId): array
    {
        return $this->findBy([
            'ownerId' => $ownerId
        ]);
    }
}
