<?php

declare(strict_types=1);

namespace App\ItemCard\Query;

use Symfony\Component\Uid\Uuid;

class GetItemCardFrontHtml
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
