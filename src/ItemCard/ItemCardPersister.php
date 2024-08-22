<?php

declare(strict_types=1);

namespace App\ItemCard;

use App\Exception\PersisterException;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use App\ItemCard\Entity\ItemCard;
use Symfony\Component\Uid\Uuid;

class ItemCardPersister
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws PersisterException
     */
    public function save(ItemCard $entity): void
    {
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
            $sql = 'UPDATE item_card
                  SET title = :title,
                      description = :description,
                      origin = :origin,
                      category = :category,
                      image = :image,
                      author_id = UUID_TO_BIN(:authorId)
                  WHERE id = UUID_TO_BIN(:id);';

            $this->entityManager->getConnection()->executeQuery(
                $sql,
                [
                    'id' => $itemCard->getId()->toRfc4122(),
                    'title' => $itemCard->getTitle(),
                    'description' => $itemCard->getDescription(),
                    'origin' => $itemCard->getOrigin(),
                    'category' => $itemCard->getCategory()->value,
                    'image' => $itemCard->getImage(),
                    'authorId' => $itemCard->getAuthorId()->toRfc4122(),
                ],
                [
                    'id' => Types::STRING,
                    'title' => Types::STRING,
                    'description' => Types::STRING,
                    'origin' => Types::STRING,
                    'category' => Types::STRING,
                    'image' => Types::STRING,
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
    public function delete(Uuid $id): void
    {
        try {
            $this->entityManager->getConnection()->executeQuery(
                'DELETE FROM item_card WHERE id = UUID_TO_BIN(?)',
                [$id->toRfc4122()],
                [Types::STRING]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }
}
