<?php

declare(strict_types=1);

namespace App\ItemCard;

use App\Exception\RepositoryException;
use App\ItemCard\Entity\ItemCard;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class ItemCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemCard::class);
    }

    public function getOneById(Uuid $id): ItemCard
    {
        $entity = $this->find($id);

        if (null === $entity) {
            throw RepositoryException::notFound(ItemCard::class, $id);
        }

        return $entity;
    }
}
