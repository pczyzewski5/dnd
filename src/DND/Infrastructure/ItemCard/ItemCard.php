<?php

declare(strict_types=1);

namespace DND\Infrastructure\ItemCard;

class ItemCard
{
    public ?string $id;
    public ?string $title;
    public ?string $description;
    public ?string $origin;
    public ?string $category;
    public ?string $authorId;
    public ?\DateTime $createdAt;
}
