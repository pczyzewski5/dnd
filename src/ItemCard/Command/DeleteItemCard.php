<?php

declare(strict_types=1);

namespace App\ItemCard\Command;

class DeleteItemCard
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
