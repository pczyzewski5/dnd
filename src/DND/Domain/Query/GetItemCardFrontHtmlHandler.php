<?php

declare(strict_types=1);

namespace DND\Domain\Query;

use DND\Domain\ItemCard\ItemCardRepository;
use Twig\Environment;

class GetItemCardFrontHtmlHandler
{
    private Environment $twig;
    private ItemCardRepository $repository;
    private string $itemCardStylesPath;

    public function __construct(
        Environment $twig,
        ItemCardRepository $repository,
        string $itemCardStylesPath,
    ) {
        $this->twig = $twig;
        $this->repository = $repository;
        $this->itemCardStylesPath = $itemCardStylesPath;
    }

    public function __invoke(GetItemCardFrontHtml $query): string
    {
        $title = $query->getTitle();
        $description = $query->getDescription();
        $origin = $query->getOrigin();

        if (null !== $query->getId()) {
            $itemCard = $this->repository->getOneById($query->getId());

            $title = $itemCard->getTitle();
            $description = $itemCard->getDescription();
            $origin = $itemCard->getOrigin();
        }

        return $this->twig->render('item_card/item_card/front.html.twig', [
            'title' => $title,
            'description' => $description,
            'origin' => $origin,
            'styles' => \file_get_contents($this->itemCardStylesPath)
        ]);
    }
}
