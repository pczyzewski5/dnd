<?php

declare(strict_types=1);

namespace App\Calendar\Domain\Model;

use App\Calendar\Infrastructure\Persistance\Entity\Calendar;
use Symfony\Component\Uid\Uuid;

class CalendarFactory
{
    public static function create(
        string $title,
        bool   $isPublic,
        Uuid   $ownerUuid,
        array  $dates
    ): Calendar {
        return new Calendar(
            Uuid::v1(),
            $title,
            $isPublic,
            $ownerUuid,
            $dates,
            new \DateTimeImmutable(),
        );
    }
}
