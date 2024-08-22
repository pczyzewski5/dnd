<?php

declare(strict_types=1);

namespace App\Character\Query;

use Symfony\Component\Uid\Uuid;

class GetCharacterCardHtml
{
    public function __construct(private readonly Uuid $id)
    {
    }

    public function getId(): Uuid
    {
        return $this->id;
    }
}
