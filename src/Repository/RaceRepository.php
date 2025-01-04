<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CharacterClass;
use App\Entity\Origin;
use App\Entity\Race;
use App\Entity\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Race::class);
    }

    public function getOneByName(string $name): Race
    {
        $result = $this->findOneBy(['name' => $name]);

        if (null === $result) {
            throw new \Exception(
                sprintf('Missing race record for: %s.', $name)
            );
        }

        return $result;
    }
}
