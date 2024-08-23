<?php

declare(strict_types=1);

namespace App\ItemCard\Query;

use App\ItemCard\Entity\ItemCard;
use App\Service\EntityService;
use Twig\Environment;

class GetItemCardBackHtmlHandler
{
    public function __construct(
        private readonly Environment $twig,
        private readonly EntityService $entityService,
        private readonly string $itemCardStylesPath,
    ) {
    }

    public function handle(GetItemCardBackHtml $query): string
    {
        $title = null;
        $image = null;
        $origin = null;

        if (null !== $query->getId()) {
            $itemCard = $this->entityService->getByUuid(
                $query->getId(),
                ItemCard::class
            );

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
