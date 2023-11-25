<?php

declare(strict_types=1);

namespace DND\Domain\Query;

use DND\Domain\ItemCard\ItemCard;
use Doctrine\ORM\EntityManagerInterface;

class GetItemCardsForListHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return ItemCard[]
     */
    public function __invoke(GetItemCardsForList $query): array
    {
        $sql = 'SELECT ic.id, ic.title, ic.description, ic.origin, ic.category, u.email as author, ic.created_at 
                FROM item_cards ic LEFT JOIN users u ON u.id = ic.author_id';

        $stmt = $this->entityManager->getConnection()->executeQuery($sql);

        return $stmt->fetchAllAssociative();
    }
}
