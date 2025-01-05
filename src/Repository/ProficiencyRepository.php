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

    public function getByNames(array $names): array
    {
        $result = $this->createQueryBuilder('p')
            ->where('p.name IN (:names)')
            ->setParameter('names', $names)
            ->getQuery()
            ->getResult();

        $missingProficiencies = array_diff(
            array_map(
                fn (Proficiency $proficiency): string => $proficiency->getName(),
                $result
            ),
            $names
        );

        if ($missingProficiencies === []) {
            return $result;
        }

        throw new Exception(
            sprintf(
                'Proficiencies: %s, not found.',
                implode(', ', $missingProficiencies)
            )
        );
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
