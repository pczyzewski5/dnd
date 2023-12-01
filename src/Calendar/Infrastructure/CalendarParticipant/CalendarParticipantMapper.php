<?php

declare(strict_types=1);

namespace Calendar\Infrastructure\CalendarParticipant;

use DateTime;
use Calendar\Domain\CalendarParticipant\CalendarParticipant as DomainEntity;
use App\DateTimeNormalizer;
use Calendar\Domain\CalendarParticipant\CalendarParticipantDTO;

class CalendarParticipantMapper
{
    public static function toDomain(CalendarParticipant $entity): DomainEntity
    {
        $dto = new CalendarParticipantDTO();
        $dto->calendarId = $entity->calendarId;
        $dto->participantId = $entity->participantId;
        $dto->data = $entity->data;
        $dto->createdAt = DateTimeNormalizer::normalizeToImmutable(
            $entity->createdAt
        );

        return new DomainEntity($dto);
    }

    public static function fromDomain(DomainEntity $domainEntity): CalendarParticipant
    {
        $entity = new CalendarParticipant();
        $entity->calendarId = $domainEntity->getCalendarId();
        $entity->participantId = $domainEntity->getParticipantId();
        $entity->data = $domainEntity->getData();
        $entity->createdAt = DateTime::createFromImmutable(
            $domainEntity->getCreatedAt()
        );

        return $entity;
    }

    /**
     * @return DomainEntity[]
     */
    public static function mapArrayToDomain(array $entities): array
    {
        return \array_map(
            static fn (CalendarParticipant $entity) => self::toDomain($entity),
            $entities
        );
    }
}
