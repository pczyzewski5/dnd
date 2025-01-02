<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Requirement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

class RequirementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Requirement::class);
    }

    /**
     * @return Requirement[]
     */
    public function findRequirementsByCharacterClass(string $name): array
    {
        $sql =
            <<<SQL
            SELECT r.* FROM requirement r
                INNER JOIN pivot_requirement_to_character_class prtcc ON r.id = prtcc.requirement_id
                INNER JOIN character_class cc ON prtcc.character_class_id = cc.id
            WHERE cc.name = :name
            SQL;

        return $this->getEntityManager()
            ->createNativeQuery($sql, $this->getResultSetMapping())
            ->setParameter('name', $name)
            ->getResult();
    }

    /**
     * @return Requirement[]
     */
    public function findRequirementsByRace(string $name): array
    {
        $sql =
            <<<SQL
            SELECT r.* FROM requirement r
                INNER JOIN pivot_requirement_to_race prtr ON r.id = prtr.requirement_id 
                INNER JOIN race rc ON prtr.race_id = rc.id
            WHERE rc.name = :name
            SQL;

        return $this->getEntityManager()
            ->createNativeQuery($sql, $this->getResultSetMapping())
            ->setParameter('name', $name)
            ->getResult();
    }

    private function getResultSetMapping(): ResultSetMapping
    {
        return (new ResultSetMapping())
            ->addEntityResult(Requirement::class, 'r')
            ->addFieldResult('r', 'id', 'id')
            ->addFieldResult('r', 'name', 'name')
            ->addFieldResult('r', 'config', 'config');
    }
}
