<?php

declare(strict_types=1);

namespace App\ItemCard\Entity;

use App\Enum\ItemCardCategoryEnum;
use Symfony\Component\Uid\Uuid;

class ItemCardFactory
{
    public static function create(
        string $title,
        string $description,
        string $origin,
        ItemCardCategoryEnum $category,
        Uuid $authorId,
        ?string $image
    ): ItemCard {
        return new ItemCard(
            $title,
            $description,
            $origin,
            $category,
            $authorId,
            $image,
        );
    }
}
