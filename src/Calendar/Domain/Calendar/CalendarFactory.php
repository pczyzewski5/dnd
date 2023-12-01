<?php

declare(strict_types=1);

namespace Calendar\Domain\Calendar;

use Symfony\Component\Uid\Uuid;

class CalendarFactory
{
    public static function create(
    string $title,
    bool $isPublic,
    string $ownerId,
    ): Calendar {
        $dto = new CalendarDTO();
        $dto->id = Uuid::v1()->toRfc4122();
        $dto->title = $title;
        $dto->isPublic = $isPublic;
        $dto->ownerId = $ownerId;
        $dto->createdAt = new \DateTimeImmutable();

        return new Calendar($dto);
    }
}
