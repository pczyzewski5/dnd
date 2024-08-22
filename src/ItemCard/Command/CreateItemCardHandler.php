<?php

declare(strict_types=1);

namespace App\ItemCard\Command;

use App\ItemCard\Entity\ItemCardFactory;
use App\ItemCard\ItemCardPersister;

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
            $command->getAuthorId(),
            $command->getImage(),
        );

        $this->persister->save($itemCard);

        return $itemCard->getId();
    }
}
