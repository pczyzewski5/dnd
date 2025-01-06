<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Proficiency;
use App\Entity\Requirement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

use function array_diff;
use function array_map;
use function implode;
use function sprintf;

class ProficiencyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Proficiency::class);
    }

    public function getByName(string $name): Proficiency
    {
        $result = $this->createQueryBuilder('p')
            ->where('p.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();

        if ($result === null) {
            throw new Exception(
                sprintf('Proficiency: %s, not found.', $name)
            );
        }

        return $result;
    }

    public function findBySkills(array $skills): array
    {
        $sql =
            <<<SQL
            SELECT p.* FROM proficiency p
                INNER JOIN pivot_proficiency_to_skill ppts ON p.id = ppts.proficiency_id
                INNER JOIN skill s ON ppts.skill_id = s.id
            WHERE s.name IN (:skills)
            SQL;

        return $this->getEntityManager()
            ->createNativeQuery($sql, $this->getResultSetMapping())
            ->setParameter('skills', $skills)
            ->getResult();
    }

    private function getResultSetMapping(): ResultSetMapping
    {
        return (new ResultSetMapping())
            ->addEntityResult(Proficiency::class, 'p')
            ->addFieldResult('p', 'id', 'id')
            ->addFieldResult('p', 'name', 'name')
            ->addFieldResult('p', 'category', 'category');
    }
}
