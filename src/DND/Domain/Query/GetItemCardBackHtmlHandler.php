<?php

declare(strict_types=1);

namespace DND\Domain\Query;

use DND\Domain\ItemCard\ItemCardRepository;
use Twig\Environment;

class GetItemCardBackHtmlHandler
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

    public function __invoke(GetItemCardBackHtml $query): string
    {
        $title = $query->getTitle();
        $image = $query->getImage();
        $origin = $query->getOrigin();

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
