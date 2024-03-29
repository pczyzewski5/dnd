<?php

declare(strict_types=1);

namespace DND\Domain\Query;

use DND\Domain\Character\CharacterRepository;
use DND\Domain\ItemCard\ItemCard;

class GetCharactersByOwnerHandler
{
    private CharacterRepository $repository;

    public function __construct(CharacterRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return ItemCard[]
     */
    public function __invoke(GetCharactersByOwner $query): array
    {
        if (\in_array('ROLE_ADMIN', $query->getUser()->getRoles())) {
            return $this->repository->findAll();
        }

        return $this->repository->findByOwner($query->getUser()->getId());
    }
}
