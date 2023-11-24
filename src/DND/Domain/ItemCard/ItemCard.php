<?php

declare(strict_types=1);

namespace DND\Domain\ItemCard;

use DND\Domain\Enum\ItemCardCategoryEnum;
use DND\Domain\ItemCard\Exception\ItemCardValidationException;
use DND\Domain\MergerTrait;
use Symfony\Component\Uid\UuidV1;

class ItemCard
{
    use MergerTrait;

    private string $id;
    private string $title;
    private string $description;
    private string $origin;
    private ItemCardCategoryEnum $category;
    private string $authorId;
    private \DateTimeImmutable $createdAt;

    public function __construct(ItemCardDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(ItemCardDTO $dto): void
    {
        $this->merge($dto);
        $this->validate();
    }

    private function validate(): void
    {
        if (!isset($this->id) && UuidV1::isValid($this->id)) {
            throw ItemCardValidationException::missingProperty('id');
        }

        if (!isset($this->title) || '' === $this->title) {
            throw ItemCardValidationException::missingProperty('title');
        }

        if (!isset($this->description) || '' === $this->description) {
            throw ItemCardValidationException::missingProperty('description');
        }

        if (!isset($this->origin) || '' === $this->origin) {
            throw ItemCardValidationException::missingProperty('origin');
        }

        if (ItemCardCategoryEnum::isValid($this->category)) {
            throw ItemCardValidationException::missingProperty('category');
        }

        if (!isset($this->authorId) && UuidV1::isValid($this->authorId)) {
            throw ItemCardValidationException::missingProperty('authorId');
        }

        if (!isset($this->createdAt)) {
            throw ItemCardValidationException::missingProperty('createdAt');
        }
    }

    public function getId(): string
    {
        return $this->id;
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

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
