<?php

declare(strict_types=1);

namespace DND\Domain\ItemCard;

use DND\Domain\ItemCard\Exception\ItemCardNotFoundException;

interface ItemCardRepository
{
    /**
     * @throws ItemCardNotFoundException
     */
    public function getOneById(string $id): ItemCard;

    /**
     * @return ItemCard[]
     */
    public function findAll(): array;
}
