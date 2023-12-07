<?php

declare(strict_types=1);

namespace Calendar\Domain\CalendarParticipant;

use Symfony\Component\Uid\UuidV1;
use Calendar\Domain\Exception\ValidationException;

class CalendarParticipant
{
    private string $calendarId;
    private string $participantId;
    private ?array $willAttend = null;
    private ?array $maybeAttend = null;
    private ?array $wontAttend = null;
    private \DateTimeImmutable $createdAt;

    public function __construct(CalendarParticipantDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(CalendarParticipantDTO $dto): void
    {
        $this->merge($dto);
        $this->validate();
    }

    private function validate(): void
    {
        if (!isset($this->calendarId) && UuidV1::isValid($this->calendarId)) {
            throw ValidationException::missingProperty('calendarId');
        }

        if (!isset($this->participantId) && UuidV1::isValid($this->participantId)) {
            throw ValidationException::missingProperty('participantId');
        }

        if (!isset($this->createdAt)) {
            throw ValidationException::missingProperty('createdAt');
        }
    }

    public function getCalendarId(): string
    {
        return $this->calendarId;
    }

    public function getParticipantId(): string
    {
        return $this->participantId;
    }

    public function getWillAttend(): ?array
    {
        return $this->willAttend;
    }

    public function getMaybeAttend(): ?array
    {
        return $this->maybeAttend;
    }

    public function getWontAttend(): ?array
    {
        return $this->wontAttend;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    private function merge(CalendarParticipantDTO $dto)
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
