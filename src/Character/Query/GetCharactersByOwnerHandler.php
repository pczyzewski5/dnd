<?php

declare(strict_types=1);

namespace App\Character\Query;

use App\Character\Character;
use App\Character\CharacterFactory;
use App\PlayerCharacter\Repository\PlayerCharacterRepository;

class GetCharactersByOwnerHandler
{
    public function __construct(private readonly PlayerCharacterRepository $repository)
    {
    }

    /**
     * @return Character[]
     */
    public function handle(GetCharactersByOwner $query): array
    {
        $result = \in_array('ROLE_ADMIN', $query->getUser()->getRoles())
            ? $this->repository->findAll()
            : $this->repository->findByOwner($query->getUser()->getId());

        return CharacterFactory::createManyFromEntities($result);
    }
}
