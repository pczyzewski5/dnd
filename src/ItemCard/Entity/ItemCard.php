<?php

declare(strict_types=1);

namespace App\ItemCard\Entity;

use App\Enum\ItemCardCategoryEnum;
use App\ItemCard\ItemCardRepository;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping;

#[Mapping\Entity(repositoryClass: ItemCardRepository::class)]
class ItemCard
{
    #[Mapping\Id]
    #[Mapping\Column(type: 'uuid', length: 36, nullable: false)]
    #[Mapping\CustomIdGenerator(class: Uuid::class)]
    private Uuid $id;

    #[Mapping\Column(type: 'string', length: 72, nullable: false)]
    private string $title;

    #[Mapping\Column(type: 'text', nullable: false)]
    private string $description;

    #[Mapping\Column(type: 'string', length: 72, nullable: false)]
    private string $origin;

    #[Mapping\Column(type: 'string', length: 36, nullable: false)]
    private string $category;

    #[Mapping\Column(type: 'uuid', length: 36, nullable: false)]
    private Uuid $authorId;

    #[Mapping\Column(type: 'text', nullable: true)]
    private ?string $image;

    #[Mapping\Column(type: 'datetime_immutable', nullable: false)]
    private \DateTimeImmutable $createdAt;

    public function __construct(
        string $title,
        string $description,
        string $origin,
        ItemCardCategoryEnum $category,
        Uuid $authorId,
        ?string $image = null,
    ) {
        $this->id = Uuid::v1();
        $this->title = $title;
        $this->description = $description;
        $this->origin = $origin;
        $this->category = $category->value;
        $this->authorId = $authorId;
        $this->image = $image;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): ItemCard
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): ItemCard
    {
        $this->description = $description;
        return $this;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): ItemCard
    {
        $this->origin = $origin;
        return $this;
    }

    public function getCategory(): ItemCardCategoryEnum
    {
        return ItemCardCategoryEnum::from($this->category);
    }

    public function setCategory(ItemCardCategoryEnum $category): ItemCard
    {
        $this->category = $category->value;

        return $this;
    }

    public function getAuthorId(): Uuid
    {
        return $this->authorId;
    }

    public function setAuthorId(Uuid $authorId): ItemCard
    {
        $this->authorId = $authorId;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): ItemCard
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): ItemCard
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
