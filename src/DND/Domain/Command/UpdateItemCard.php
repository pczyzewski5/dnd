<?php

declare(strict_types=1);

namespace DND\Domain\Command;

use DND\Domain\ItemCard\ItemCard;

class UpdateItemCard
{
    private ItemCard $originalItemCard;
    private string $title;
    private string $description;
    private string $origin;
    private string $category;
    private ?string $image;

    public function __construct(
        ItemCard $originalItemCard,
        string $title,
        string $description,
        string $origin,
        string $category,
        ?string $image,
    ) {
        $this->originalItemCard = $originalItemCard;
        $this->title = $title;
        $this->description = $description;
        $this->origin = $origin;
        $this->category = $category;
        $this->image = $image;
    }

    public function getOriginalItemCard(): ItemCard
    {
        return $this->originalItemCard;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }
}
