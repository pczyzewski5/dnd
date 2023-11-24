<?php

declare(strict_types=1);

namespace DND\Domain\Command;

use DND\Domain\ItemCard\ItemCardFactory;
use DND\Domain\ItemCard\ItemCardPersister;

class CreateItemCardHandler
{
    private ItemCardPersister $persister;

    public function __construct(ItemCardPersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(CreateItemCard $command): string
    {
        $itemCard = ItemCardFactory::create(
            $command->getTitle(),
            $command->getDescription(),
            $command->getOrigin(),
            $command->getCategory(),
            $command->getAuthorId()
        );

        $this->persister->save($itemCard);

        return $itemCard->getId();
    }
}
