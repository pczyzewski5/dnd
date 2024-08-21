<?php

declare(strict_types=1);

namespace App\Character;

use App\DND\Character\Chara;
use App\DND\Character\Character;
use Doctrine\ORM\EntityManagerInterface;
use App\Character\Entity\CharacterFactory;
use App\Character\Exception\CharacterNotFoundException;

class CharacterRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOneById(string $id): Chara
    {
        $entity = $this->entityManager->getRepository(Character::class)->find($id);

        if (null === $entity) {
            throw CharacterNotFoundException::notFound($id);
        }

        return CharacterFactory::createFromEntity($entity);
    }

    /**
     * @return []
     */
    public function findAll(): array
    {
        return CharacterFactory::createManyFromEntities(
            $this->entityManager->getRepository(Character::class)->findAll()
        );
    }

    /**
     * @return []
     */
    public function findByOwner(string $ownerId): array
    {
        $characters = $this->entityManager->getRepository(Character::class)->findBy([
            'ownerId' => $ownerId
        ]);

        return CharacterFactory::createManyFromEntities($characters);
    }
}
