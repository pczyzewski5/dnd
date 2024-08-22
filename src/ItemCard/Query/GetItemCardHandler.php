<?php

declare(strict_types=1);

namespace App\ItemCard\Query;

use App\ItemCard\Entity\ItemCard;
use App\ItemCard\ItemCardRepository;

class GetItemCardHandler
{
    public function __construct(private readonly ItemCardRepository $repository)
    {
    }

    public function handle(GetItemCard $command): ItemCard
    {
        return $this->repository->getOneById($command->getId());
    }
}
