<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Proficiency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

use function array_diff;
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
}
