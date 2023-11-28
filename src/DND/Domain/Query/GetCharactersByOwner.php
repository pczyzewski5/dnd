<?php

declare(strict_types=1);

namespace DND\Domain\Query;

class GetCharactersByOwner
{
    private string $ownerId;

    public function __construct(string $ownerId)
    {
        $this->ownerId = $ownerId;
    }

    public function getOwnerId(): string
    {
        return $this->ownerId;
    }
}
