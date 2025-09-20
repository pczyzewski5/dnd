<?php

declare(strict_types=1);

namespace App\Calendar\Infrastructure\Persistance\Entity;

use Doctrine\ORM\Mapping;
use Symfony\Component\Uid\Uuid;

#[Mapping\Entity]
#[Mapping\Table(name: 'calendar_participant')]
class CalendarParticipant
{
    #[Mapping\Id]
    #[Mapping\Column(type: 'uuid', nullable: false)]
    private Uuid $calendarId;

    #[Mapping\Id]
    #[Mapping\Column(type: 'uuid', nullable: false)]
    private Uuid $participantId;

    #[Mapping\Column(type: 'json', nullable: true)]
    private ?array $willAttend;

    #[Mapping\Column(type: 'json', nullable: true)]
    private ?array $maybeAttend;

    #[Mapping\Column(type: 'json', nullable: true)]
    private ?array $wontAttend;

    #[Mapping\Column(type: 'datetime_immutable', nullable: false)]
    private \DateTimeImmutable $createdAt;

    public function __construct(
        Uuid $calendarId,
        Uuid $participantId,
        \DateTimeImmutable $createdAt,
        ?array $willAttend = null,
        ?array $maybeAttend = null,
        ?array $wontAttend = null,
    ) {
        $this->calendarId = $calendarId;
        $this->participantId = $participantId;
        $this->willAttend = $willAttend;
        $this->maybeAttend = $maybeAttend;
        $this->wontAttend = $wontAttend;
        $this->createdAt = $createdAt;
    }

    public function getCalendarId(): Uuid
    {
        return $this->calendarId;
    }

    public function setCalendarId(Uuid $calendarId): CalendarParticipant
    {
        $this->calendarId = $calendarId;
        return $this;
    }

    public function getParticipantId(): Uuid
    {
        return $this->participantId;
    }

    public function setParticipantId(Uuid $participantId): CalendarParticipant
    {
        $this->participantId = $participantId;
        return $this;
    }

    public function getWillAttend(): ?array
    {
        return $this->willAttend;
    }

    public function setWillAttend(?array $willAttend): CalendarParticipant
    {
        $this->willAttend = $willAttend;
        return $this;
    }

    public function getMaybeAttend(): ?array
    {
        return $this->maybeAttend;
    }

    public function setMaybeAttend(?array $maybeAttend): CalendarParticipant
    {
        $this->maybeAttend = $maybeAttend;
        return $this;
    }

    public function getWontAttend(): ?array
    {
        return $this->wontAttend;
    }

    public function setWontAttend(?array $wontAttend): CalendarParticipant
    {
        $this->wontAttend = $wontAttend;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): CalendarParticipant
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    private function merge()
    {
        $properties = \array_keys(
            \get_class_vars(self::class)
        );

        foreach ($properties as $property) {
            if (isset($dto->$property)) {
                $this->$property = $dto->$property;
            }
        }

        $this->willAttend = $dto->willAttend;
        $this->maybeAttend = $dto->maybeAttend;
        $this->wontAttend = $dto->wontAttend;
    }
}
