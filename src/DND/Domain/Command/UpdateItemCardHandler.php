<?php

declare(strict_types=1);

namespace DND\Domain\Command;

use DND\Domain\Enum\ItemCardCategoryEnum;
use DND\Domain\ItemCard\ItemCardDTO;
use DND\Domain\ItemCard\ItemCardPersister;

class UpdateItemCardHandler
{
    private ItemCardPersister $persister;
    private string $itemCardImagesDirectory;

    public function __construct(
        ItemCardPersister $persister,
        string $itemCardImagesDirectory
    ) {
        $this->persister = $persister;
        $this->itemCardImagesDirectory = $itemCardImagesDirectory;
    }

    public function handle(UpdateItemCard $command)
    {
        $originalItemCard = $command->getOriginalItemCard();

        $dto = new ItemCardDTO();
        $dto->category = ItemCardCategoryEnum::from($command->getCategory());
        $dto->title = $command->getTitle();
        $dto->description = $command->getDescription();
        $dto->origin = $command->getOrigin();

        if (null !== $command->getImage()) {
            $filename = $this->itemCardImagesDirectory . '/' . $originalItemCard->getImage();
            if (false === \file_exists($filename)) {
                throw new \Exception('Cannot delete: ' . $filename . ' file, because it is not exists.');
            }

            \unlink($filename);

            $dto->image = $command->getImage();
        }

        $originalItemCard->update($dto);

        $this->persister->update($originalItemCard);
    }
}
