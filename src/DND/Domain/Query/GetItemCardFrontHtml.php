<?php

declare(strict_types=1);

namespace DND\Domain\Query;

class GetItemCardFrontHtml
{
    private ?string $id;
    private ?string $title;
    private ?string $description;

    public function __construct(
        ?string $id = null,
        ?string $title = null,
        ?string $description = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
