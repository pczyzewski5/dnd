<?php

declare(strict_types=1);

namespace App\ItemCard\Query;

use App\ItemCard\Entity\ItemCard;
use App\ItemCard\ItemCardRepository;
use App\Service\EntityService;
use Twig\Environment;

class GetItemCardFrontHtmlHandler
{
    public function __construct(
        private readonly Environment $twig,
        private readonly EntityService $entityService,
        private readonly string $itemCardStylesPath,
    ) {
    }

    public function handle(GetItemCardFrontHtml $query): string
    {
        $title = null;
        $description = null;

        if (null !== $query->getId()) {
            $itemCard = $this->entityService->getByUuid(
                $query->getId(),
                ItemCard::class
            );

            $title = $itemCard->getTitle();
            $description = $itemCard->getDescription();
        }

        return $this->twig->render('item_card/item_card/front.html.twig', [
            'title' => $title,
            'description' => $description,
            'stylesPath' => $this->itemCardStylesPath
        ]);
    }
}
