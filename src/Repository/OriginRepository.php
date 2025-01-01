<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CharacterClass;
use App\Entity\Origin;
use App\Entity\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use function sprintf;

class OriginRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Origin::class);
    }

    public function getOneByName(string $name): Origin
    {
        $result = $this->findOneBy(['name' => $name]);

        if (null === $result) {
            throw new \Exception(
                sprintf('Missing origin record for: %s.', $name)
            );
        }

        return $result;
    }
}
