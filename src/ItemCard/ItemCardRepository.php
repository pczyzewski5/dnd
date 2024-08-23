<?php

declare(strict_types=1);

namespace App\ItemCard;

use App\ItemCard\Entity\ItemCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ItemCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemCard::class);
    }
}
