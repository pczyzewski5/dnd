<?php

declare(strict_types=1);

namespace DND\Domain\Query;

use DND\Domain\ItemCard\ItemCard;
use DND\Domain\ItemCard\ItemCardRepository;

class GetItemCardsHandler
{
    private ItemCardRepository $repository;

    public function __construct(ItemCardRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return ItemCard[]
     */
    public function __invoke(GetItemCards $query): array
    {
        return $this->repository->findAll();
    }
}
