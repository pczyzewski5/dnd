<?php

declare(strict_types=1);

namespace App\ItemCard;

use App\DND\ItemCard\ItemCardRepository as DomainRepository;
use App\DND\ItemCard\ItemCard;
use App\DND\ItemCard\ItemCardMapper;
use Doctrine\ORM\EntityManagerInterface;
use App\ItemCard\Entity\ItemCard as DomainItemCard;
use App\ItemCard\Exception\ItemCardNotFoundException;

class ItemCardRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOneById(string $id): DomainItemCard
    {
        $entity = $this->entityManager->getRepository(ItemCard::class)->find($id);

        if (null === $entity) {
            throw ItemCardNotFoundException::notFound($id);
        }

        return ItemCardMapper::toDomain($entity);
    }

    /**
     * @return DomainItemCard[]
     */
    public function findAll(): array
    {
        return ItemCardMapper::mapArrayToDomain(
            $this->entityManager->getRepository(ItemCard::class)->findAll()
        );
    }
}
