<?php

declare(strict_types=1);

namespace App\Calendar\Domain\Model;

use Symfony\Component\Uid\Uuid;

class Calendar
{
    public ?Uuid $id;
    public ?string $title;
    public ?bool $isPublic;
    public ?string $ownerId;
    public ?string $dates;
    public ?\DateTime $createdAt;
}
