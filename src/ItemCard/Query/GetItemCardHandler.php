<?php

declare(strict_types=1);

namespace App\ItemCard\Query;

use App\ItemCard\Entity\ItemCard;
use App\ItemCard\ItemCardRepository;

class GetItemCardHandler
{
    private ItemCardRepository $repository;

    public function __construct(
        ItemCardRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function __invoke(GetItemCard $command): ItemCard
    {
        return $this->repository->getOneById($command->getId());
    }
}
