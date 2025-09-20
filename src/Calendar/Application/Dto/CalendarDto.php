<?php

declare(strict_types=1);

namespace App\Calendar\Application\Dto;

class CalendarDto
{
    public ?string $id = null;
    public ?string $title = null;
    public ?bool $isPublic = null;
    public ?string $ownerId = null;
    public ?array $dates = null;
    public ?\DateTimeImmutable $createdAt = null;
}
