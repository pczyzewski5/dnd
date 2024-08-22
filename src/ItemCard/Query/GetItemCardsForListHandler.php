<?php

declare(strict_types=1);

namespace App\ItemCard\Query;

use Doctrine\ORM\EntityManagerInterface;

class GetItemCardsForListHandler
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function handle(GetItemCardsForList $query): array
    {
        $sql = <<<SQL
SELECT BIN_TO_UUID(ic.id) as id, ic.title, ic.description, ic.origin, ic.category, u.email as author, ic.created_at 
FROM item_card ic 
LEFT JOIN user u ON u.id = ic.author_id
SQL;
        return $this->entityManager
            ->getConnection()
            ->executeQuery($sql)
            ->fetchAllAssociative();
    }
}
