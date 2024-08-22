<?php

declare(strict_types=1);

namespace App\ItemCard\Query;

use Doctrine\ORM\EntityManagerInterface;
use App\ItemCard\Entity\ItemCard;

class GetItemCardsForListHandler
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @return ItemCard[]
     */
    public function handle(GetItemCardsForList $query): array
    {
        $stmt = $this->entityManager->getConnection()->executeQuery(
            'SELECT ic.id, ic.title, ic.description, ic.origin, ic.category, u.email as author, ic.created_at 
                FROM item_card ic LEFT JOIN user u ON u.id = ic.author_id'
        );

        return $stmt->fetchAllAssociative();
    }
}
