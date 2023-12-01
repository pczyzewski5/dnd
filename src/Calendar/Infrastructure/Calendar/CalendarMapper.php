<?php

declare(strict_types=1);

namespace Calendar\Infrastructure\Calendar;

use DateTime;
use Calendar\Domain\Calendar\Calendar as DomainCalendar;
use App\DateTimeNormalizer;
use Calendar\Domain\Calendar\CalendarDTO;

class CalendarMapper
{
    public static function toDomain(Calendar $entity): DomainCalendar
    {
        $dto = new CalendarDTO();
        $dto->id = $entity->id;
        $dto->title = $entity->title;
        $dto->isPublic = $entity->isPublic;
        $dto->ownerId = $entity->ownerId;
        $dto->createdAt = DateTimeNormalizer::normalizeToImmutable(
            $entity->createdAt
        );

        return new DomainCalendar($dto);
    }

    public static function fromDomain(DomainCalendar $domainEntity): Calendar
    {
        $entity = new Calendar();
        $entity->id = $domainEntity->getId();
        $entity->title = $domainEntity->getTitle();
        $entity->isPublic = $domainEntity->isPublic();
        $entity->ownerId = $domainEntity->getOwnerId();
        $entity->createdAt = DateTime::createFromImmutable(
            $domainEntity->getCreatedAt()
        );

        return $entity;
    }

    /**
     * @return DomainCalendar[]
     */
    public static function mapArrayToDomain(array $entities): array
    {
        return \array_map(
            static fn (Calendar $entity) => self::toDomain($entity),
            $entities
        );
    }
}
