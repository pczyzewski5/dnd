<?php

declare(strict_types=1);

namespace DND\Domain\Query;

class GetItemCard
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
