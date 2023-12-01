<?php

namespace DND\Domain\ItemCard;

use DND\Domain\Exception\PersisterException;

interface ItemCardPersister
{
    /**
     * @throws PersisterException
     */
    public function save(ItemCard $domainEntity): void;

    /**
     * @throws PersisterException
     */
    public function update(ItemCard $itemCard): void;

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void;
}
