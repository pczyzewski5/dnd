<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CharacterClass;
use App\Entity\Level;
use App\Enum\CharacterClassEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use function sprintf;

class LevelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Level::class);
    }

    public function getByLevelAndCharacterClass(
        int $level,
        string $characterClass
    ): Level {
        try {
            return $this->createQueryBuilder('l')
                ->join('l.characterClass', 'cc')
                ->where('cc.name = :name')
                ->andWhere('l.level = :level')
                ->setParameter('name', $characterClass)
                ->setParameter('level', $level)
                ->getQuery()
                ->getSingleResult()
            ;
        } catch (NoResultException $e) {
            throw new \Exception(
                sprintf(
                    'Missing level record for level %s %s.',
                    $level,
                    $characterClass,
                )
            );
        }
    }
}
