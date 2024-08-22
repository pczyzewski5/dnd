<?php

declare(strict_types=1);

namespace App\ItemCard\Command;

use Symfony\Component\Uid\Uuid;

class CreateItemCard
{
    public function __construct(
        private readonly string $title,
        private readonly string $description,
        private readonly string $origin,
        private readonly string $category,
        private readonly Uuid $authorId,
        private readonly ?string $image,
    ) {
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

    public function getAuthorId(): Uuid
    {
        return $this->authorId;
    }
}
