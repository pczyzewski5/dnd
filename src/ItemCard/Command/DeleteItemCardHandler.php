<?php

declare(strict_types=1);

namespace App\ItemCard\Command;

use App\ItemCard\ItemCardPersister;
use App\ItemCard\ItemCardRepository;

class DeleteItemCardHandler
{
    public function __construct(
        private readonly ItemCardRepository $repository,
        private readonly ItemCardPersister $persister,
        private readonly string $itemCardImagesDirectory
    ) {
    }

    public function handle(DeleteItemCard $command): void
    {
        $itemCard = $this->repository->getOneById($command->getId());

        $this->persister->delete($itemCard->getId());

        if (null !== $itemCard->getImage()) {
            $filename = $this->itemCardImagesDirectory . '/' . $itemCard->getImage();
            if (false === \file_exists($filename)) {
                throw new \Exception('Cannot delete: ' . $filename . ' file, because it is not exists.');
            }

            \unlink($filename);
        }
    }
}
