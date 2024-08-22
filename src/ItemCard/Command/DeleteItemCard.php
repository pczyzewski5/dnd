<?php

declare(strict_types=1);

namespace App\ItemCard\Command;

use Symfony\Component\Uid\Uuid;

class DeleteItemCard
{
    public function __construct(private readonly Uuid $id)
    {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }
}
