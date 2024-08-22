<?php

declare(strict_types=1);

namespace App\ItemCard\Query;

use Symfony\Component\Uid\Uuid;

class GetItemCardBackHtml
{
    public function __construct(
        private readonly ?Uuid $id = null,
    ) {
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }
}
