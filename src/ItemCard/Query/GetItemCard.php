<?php

declare(strict_types=1);

namespace App\ItemCard\Query;

use Symfony\Component\Uid\Uuid;

class GetItemCard
{
    public function __construct(private readonly Uuid $id)
    {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }
}
