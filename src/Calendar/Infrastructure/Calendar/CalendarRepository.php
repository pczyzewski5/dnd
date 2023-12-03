<?php

declare(strict_types=1);

namespace Calendar\Infrastructure\Calendar;

use Doctrine\ORM\EntityManagerInterface;
use DND\Domain\ItemCard\Exception\ItemCardNotFoundException;
use DND\Domain\ItemCard\ItemCard as DomainItemCard;
use DND\Domain\ItemCard\ItemCardRepository as DomainRepository;

class CalendarRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOneById(string $id): DomainItemCard
    {
        $entity = $this->entityManager->getRepository(Calendar::class)->find($id);

        if (null === $entity) {
            throw ItemCardNotFoundException::notFound($id);
        }

        return CalendarMapper::toDomain($entity);
    }

    /**
     * @return DomainItemCard[]
     */
    public function findAll(): array
    {
        return CalendarMapper::mapArrayToDomain(
            $this->entityManager->getRepository(Calendar::class)->findAll()
        );
    }
}