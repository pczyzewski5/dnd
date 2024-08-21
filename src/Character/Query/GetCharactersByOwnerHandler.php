<?php

declare(strict_types=1);

namespace App\Character\Query;

use App\Character\CharacterRepository;
use App\ItemCard\Entity\ItemCard;

class GetCharactersByOwnerHandler
{
    public function __construct(private readonly CharacterRepository $repository)
    {
    }

    /**
     * @return ItemCard[]
     */
    public function handle(GetCharactersByOwner $query): array
    {
        if (\in_array('ROLE_ADMIN', $query->getUser()->getRoles())) {
            return $this->repository->findAll();
        }

        return $this->repository->findByOwner($query->getUser()->getIdAsString());
    }
}
