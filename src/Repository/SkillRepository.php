<?php

declare(strict_types=1);

namespace App\Repository;

use Exception;
use App\Entity\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use function array_diff;
use function array_map;
use function implode;
use function sprintf;

class SkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Skill::class);
    }

    public function getByNames(array $names): array
    {
        $result = $this->createQueryBuilder('s')
            ->where('s.name IN (:names)')
            ->setParameter('names', $names)
            ->getQuery()
            ->getResult();

        $missingSkills = array_diff(
            array_map(
                fn (Skill $skill): string => $skill->getName(),
                $result
            ),
            $names
        );

        if ($missingSkills === []) {
            return $result;
        }

        throw new Exception(
            sprintf(
                'Skills: %s, not found.',
                implode(', ', $missingSkills)
            )
        );
    }
}
