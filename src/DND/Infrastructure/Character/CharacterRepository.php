<?php

declare(strict_types=1);

namespace DND\Infrastructure\Character;

use DND\Domain\Character\Exception\CharacterNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use DND\Domain\Character\Character as DomainCharacter;
use DND\Domain\Character\CharacterRepository as DomainRepository;

class CharacterRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOneById(string $id): DomainCharacter
    {
        $entity = $this->entityManager->getRepository(Character::class)->find($id);

        if (null === $entity) {
            throw CharacterNotFoundException::notFound($id);
        }

        return CharacterMapper::toDomain($entity);
    }

    /**
     * @return DomainCharacter[]
     */
    public function findAll(): array
    {
        return CharacterMapper::mapArrayToDomain(
            $this->entityManager->getRepository(Character::class)->findAll()
        );
    }

    /**
     * @return DomainCharacter[]
     */
    public function findByOwner(string $ownerId): array
    {
        $characters = $this->entityManager->getRepository(Character::class)->findBy([
            'ownerId' => $ownerId
        ]);

        return CharacterMapper::mapArrayToDomain($characters);
    }
}
