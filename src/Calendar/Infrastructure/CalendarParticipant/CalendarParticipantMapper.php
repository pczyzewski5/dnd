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
        $willAttend = null === $entity->willAttend
            ? null
            : \json_decode($entity->willAttend);
        $maybeAttend = null === $entity->maybeAttend
            ? null
            : \json_decode($entity->maybeAttend);
        $wontAttend = null === $entity->wontAttend
            ? null
            : \json_decode($entity->wontAttend);

        $dto = new CalendarParticipantDTO();
        $dto->calendarId = $entity->calendarId;
        $dto->participantId = $entity->participantId;
        $dto->willAttend = $willAttend;
        $dto->maybeAttend = $maybeAttend;
        $dto->wontAttend = $wontAttend;
        $dto->createdAt = DateTimeNormalizer::normalizeToImmutable(
            $entity->createdAt
        );

        return new DomainEntity($dto);
    }

    public static function fromDomain(DomainEntity $domainEntity): CalendarParticipant
    {
        $willAttend = $domainEntity->getWillAttend();
        $willAttend = empty($willAttend) || null === $willAttend
            ? null
            : \json_encode($willAttend);
        $maybeAttend = $domainEntity->getMaybeAttend();
        $maybeAttend = empty($maybeAttend) || null === $maybeAttend
            ? null
            : \json_encode($maybeAttend);
        $wontAttend = $domainEntity->getWontAttend();
        $wontAttend = empty($wontAttend) || null === $wontAttend
            ? null
            : \json_encode($wontAttend);

        $entity = new CalendarParticipant();
        $entity->calendarId = $domainEntity->getCalendarId();
        $entity->participantId = $domainEntity->getParticipantId();
        $entity->willAttend = $willAttend;
        $entity->maybeAttend = $maybeAttend;
        $entity->wontAttend = $wontAttend;
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
