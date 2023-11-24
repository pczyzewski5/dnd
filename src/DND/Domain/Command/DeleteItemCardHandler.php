<?php

declare(strict_types=1);

namespace DND\Domain\Command;

use DND\Domain\ItemCard\ItemCardPersister;
use DND\Domain\ItemCard\ItemCardRepository;

class DeleteItemCardHandler
{
    private ItemCardRepository $repository;
    private ItemCardPersister $persister;
    private string $itemCardImagesDirectory;

    public function __construct(
        ItemCardRepository $repository,
        ItemCardPersister $persister,
        string $itemCardImagesDirectory
    ) {
        $this->repository = $repository;
        $this->persister = $persister;
        $this->itemCardImagesDirectory = $itemCardImagesDirectory;
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
