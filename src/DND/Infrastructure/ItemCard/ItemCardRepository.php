<?php

declare(strict_types=1);

namespace DND\Infrastructure\ItemCard;

use Doctrine\ORM\EntityManagerInterface;
use DND\Domain\ItemCard\Exception\ItemCardNotFoundException;
use DND\Domain\ItemCard\ItemCard as DomainItemCard;
use DND\Domain\ItemCard\ItemCardRepository as DomainRepository;

class ItemCardRepository implements DomainRepository
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
