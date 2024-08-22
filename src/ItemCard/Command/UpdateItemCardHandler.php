<?php

declare(strict_types=1);

namespace App\ItemCard\Command;

use App\Enum\ItemCardCategoryEnum;
use App\ItemCard\ItemCardPersister;

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

        if (null !== $command->getImage()) {
            if (null !== $originalItemCard->getImage()) {
                $filename = $this->itemCardImagesDirectory . '/' . $originalItemCard->getImage();
                if (false === \file_exists($filename)) {
                    throw new \Exception('Cannot delete: ' . $filename . ' file, because it is not exists.');
                }

                \unlink($filename);
            }

            $originalItemCard->setImage($command->getImage());
        }

        $originalItemCard
            ->setCategory(ItemCardCategoryEnum::from($command->getCategory()))
            ->setTitle($command->getTitle())
            ->setDescription($command->getDescription())
            ->setOrigin($command->getOrigin());

        $this->persister->update($originalItemCard);
    }
}
