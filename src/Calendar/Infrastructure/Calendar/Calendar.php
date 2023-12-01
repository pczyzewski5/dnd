<?php

declare(strict_types=1);

namespace Calendar\Infrastructure\Calendar;

class Calendar
{
    public ?string $id;
    public ?string $title;
    public ?bool $isPublic;
    public ?string $ownerId;
    public ?\DateTime $createdAt;
}
