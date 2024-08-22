<?php

declare(strict_types=1);

namespace App\ItemCard\Command;

use App\Enum\ItemCardCategoryEnum;
use App\ItemCard\Entity\ItemCardFactory;
use App\ItemCard\ItemCardPersister;
use Symfony\Component\Uid\Uuid;

class CreateItemCardHandler
{
    private ItemCardPersister $persister;

    public function __construct(ItemCardPersister $persister)
    {
        $this->persister = $persister;
    }

    public function handle(CreateItemCard $command): Uuid
    {
        $itemCard = ItemCardFactory::create(
            $command->getTitle(),
            $command->getDescription(),
            $command->getOrigin(),
            ItemCardCategoryEnum::from($command->getCategory()),
            $command->getAuthorId(),
            $command->getImage(),
        );

        $this->persister->save($itemCard);

        return $itemCard->getId();
    }
}
