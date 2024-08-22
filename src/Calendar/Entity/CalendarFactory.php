<?php

declare(strict_types=1);

namespace App\Calendar\Entity;

use Symfony\Component\Uid\Uuid;

class CalendarFactory
{
    public static function create(
        string $title,
        bool $isPublic,
        string $ownerId,
        array $dates
    ): Calendar {
        return new Calendar(
            Uuid::v1(),
            $title,
            $isPublic,
            $ownerId,
            $dates,
            new \DateTimeImmutable(),
        );
    }
}
