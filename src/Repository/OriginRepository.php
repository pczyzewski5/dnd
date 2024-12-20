<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CharacterClass;
use App\Entity\Origin;
use App\Entity\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OriginRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Origin::class);
    }
}
