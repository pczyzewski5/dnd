<?php

declare(strict_types=1);

namespace DND\Domain\Query;

class GetItemCardBackHtml
{
    private ?string $id;
    private ?string $title;
    private ?string $image;
    private ?string $origin;

    public function __construct(
        ?string $id = null,
        ?string $title = null,
        ?string $image = null,
        ?string $origin = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->image = $image;
        $this->origin = $origin;
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

    public function getOrigin(): ?string
    {
        return $this->origin;
    }
}
