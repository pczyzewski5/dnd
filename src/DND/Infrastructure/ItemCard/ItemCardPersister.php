<?php

declare(strict_types=1);

namespace DND\Infrastructure\ItemCard;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use DND\Domain\ItemCard\ItemCardPersister as DomainPersister;
use DND\Domain\ItemCard\ItemCard;
use DND\Domain\Exception\PersisterException;

class ItemCardPersister implements DomainPersister
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws PersisterException
     */
    public function save(ItemCard $itemCard): void
    {
        $entity = ItemCardMapper::fromDomain($itemCard);

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    public function update(ItemCard $itemCard): void
    {
        try {
            $sql = 'UPDATE item_cards
                  SET title = :title,
                      description = :description,
                      origin = :origin,
                      category = :category,
                      author_id = :authorId
                  WHERE id = :id;';

            $this->entityManager->getConnection()->executeQuery(
                $sql,
                [
                    'id' => $itemCard->getId(),
                    'title' => $itemCard->getTitle(),
                    'description' => $itemCard->getDescription(),
                    'origin' => $itemCard->getOrigin(),
                    'category' => $itemCard->getCategory()->getValue(),
                    'authorId' => $itemCard->getAuthorId(),
                ],
                [
                    'id' => Types::STRING,
                    'title' => Types::STRING,
                    'description' => Types::STRING,
                    'origin' => Types::STRING,
                    'category' => Types::STRING,
                    'authorId' => Types::STRING,
                ]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void
    {
        try {
            $this->entityManager->getConnection()->executeQuery(
                'DELETE FROM item_cards WHERE id = ?',
                [$id],
                [Types::STRING]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }
}
