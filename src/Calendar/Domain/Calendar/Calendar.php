<?php

declare(strict_types=1);

namespace Calendar\Domain\Calendar;

use App\MergerTrait;
use Symfony\Component\Uid\UuidV1;
use Calendar\Domain\Exception\ValidationException;

class Calendar
{
    use MergerTrait;

    private string $id;
    private string $title;
    private bool $isPublic;
    private string $ownerId;
    private \DateTimeImmutable $createdAt;

    public function __construct(CalendarDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(CalendarDTO $dto): void
    {
        $this->merge($dto);
        $this->validate();
    }

    private function validate(): void
    {
        if (!isset($this->id) && UuidV1::isValid($this->id)) {
            throw ValidationException::missingProperty('id');
        }

        if (!isset($this->title) || '' === $this->title) {
            throw ValidationException::missingProperty('title');
        }

        if (!isset($this->ownerId) && UuidV1::isValid($this->ownerId)) {
            throw ValidationException::missingProperty('ownerId');
        }

        if (!isset($this->createdAt)) {
            throw ValidationException::missingProperty('createdAt');
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    public function getOwnerId(): string
    {
        return $this->ownerId;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
