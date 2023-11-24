<?php

declare(strict_types=1);

namespace DND\Domain\Command;

use DND\Domain\Enum\ItemCardCategoryEnum;

class CreateItemCard
{
    private string $title;
    private string $description;
    private string $origin;
    private ItemCardCategoryEnum $category;
    private ?string $image;
    private string $authorId;

    public function __construct(
        string $title,
        string $description,
        string $origin,
        ItemCardCategoryEnum $category,
        string $authorId,
        ?string $image,
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->origin = $origin;
        $this->category = $category;
        $this->image = $image;
        $this->authorId = $authorId;
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

    public function getCategory(): ItemCardCategoryEnum
    {
        return $this->category;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }
}
