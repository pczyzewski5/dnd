<?php

declare(strict_types=1);

namespace App\PlayerCharacter\Repository;

use App\PlayerCharacter\Entity\PlayerCharacter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class PlayerCharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayerCharacter::class);
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
