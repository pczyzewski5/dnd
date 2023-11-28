<?php

declare(strict_types=1);

namespace DND\Infrastructure\Character;

class Character
{
    public ?string $id;
    public ?string $data;
    public ?string $ownerId;
    public ?\DateTime $createdAt;
}
