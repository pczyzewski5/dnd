<?php

declare(strict_types=1);

namespace DND\Domain\ItemCard;

use DND\Domain\Enum\ItemCardCategoryEnum;

class ItemCardDTO
{
    public ?string $id = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?string $origin = null;
    public ?ItemCardCategoryEnum $category = null;
    public ?string $authorId = null;
    public ?string $image = null;
    public ?\DateTimeImmutable $createdAt = null;
}
