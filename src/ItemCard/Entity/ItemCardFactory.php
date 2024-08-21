<?php

declare(strict_types=1);

namespace App\ItemCard\Entity;

use App\Enum\ItemCardCategoryEnum;
use App\ItemCard\ItemCardDTO;
use Symfony\Component\Uid\Uuid;

class ItemCardFactory
{
    public static function create(
        string $title,
        string $description,
        string $origin,
        ItemCardCategoryEnum $category,
        string $authorId,
        ?string $image
    ): ItemCard {
        $dto = new ItemCardDTO();
        $dto->id = Uuid::v1()->toRfc4122();
        $dto->title = $title;
        $dto->description = $description;
        $dto->origin = $origin;
        $dto->category = $category;
        $dto->authorId = $authorId;
        $dto->image = $image;
        $dto->createdAt = new \DateTimeImmutable();

        return new ItemCard($dto);
    }
}
