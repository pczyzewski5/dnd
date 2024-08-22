<?php

declare(strict_types=1);

namespace App\ItemCard\Query;

use App\ItemCard\ItemCardRepository;
use Twig\Environment;

class GetItemCardBackHtmlHandler
{
    public function __construct(
        private readonly Environment $twig,
        private readonly ItemCardRepository $repository,
        private readonly string $itemCardStylesPath,
    ) {
    }

    public function handle(GetItemCardBackHtml $query): string
    {
        $title = null;
        $image = null;
        $origin = null;

        if (null !== $query->getId()) {
            $itemCard = $this->repository->getOneById($query->getId());

            $title = $itemCard->getTitle();
            $image = $itemCard->getImage();
            $origin = $itemCard->getOrigin();
        }

        return $this->twig->render('item_card/item_card/back.html.twig', [
            'title' => $title,
            'image' => $image,
            'origin' => $origin,
            'stylesPath' => $this->itemCardStylesPath
        ]);
    }
}
