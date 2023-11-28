<?php

declare(strict_types=1);

namespace DND\Domain\Character\Exception;

use DND\Domain\Exception\ValidationException;

class CharacterNotFoundException extends ValidationException
{
    public static function notFound(string $id): self
    {
        return new self(
            \sprintf('Character with id: %s not found.', $id)
        );
    }
}
