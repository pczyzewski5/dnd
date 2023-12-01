<?php

declare(strict_types=1);

namespace Calendar\Domain\CalendarParticipant;

use App\MergerTrait;
use Symfony\Component\Uid\UuidV1;
use Calendar\Domain\Exception\ValidationException;

class CalendarParticipant
{
    use MergerTrait;

    private string $calendarId;
    private string $participantId;
    private string $data;
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

        if (!isset($this->data) || '' === $this->data) {
            throw ValidationException::missingProperty('data');
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

    public function getData(): string
    {
        return $this->data;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
