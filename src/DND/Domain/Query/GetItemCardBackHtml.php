<?php

declare(strict_types=1);

namespace DND\Domain\Query;

class GetItemCardBackHtml
{
    private ?string $id;
    private ?string $title;
    private ?string $image;

    public function __construct(
        ?string $id = null,
        ?string $title = null,
        ?string $image = null,
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->image = $image;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }
}
