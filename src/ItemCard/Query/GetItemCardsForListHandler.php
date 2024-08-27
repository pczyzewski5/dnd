<?php

declare(strict_types=1);

namespace App\ItemCard\Query;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Uid\Uuid;

use function array_map;
use function var_dump;

class GetItemCardsForListHandler
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function handle(GetItemCardsForList $query): array
    {
        $sql = <<<SQL
SELECT ic.id as id, ic.title, ic.description, ic.origin, ic.category, u.email as author, ic.created_at 
FROM item_card ic 
LEFT JOIN user u ON u.id = ic.author_id
SQL;
        $result = $this->entityManager
            ->getConnection()
            ->executeQuery($sql)
            ->fetchAllAssociative();

        return array_map(static function(array $data): array {
            $data['id'] = Uuid::fromBinary($data['id'])->toRfc4122();

            return $data;
        }, $result);
    }
}
