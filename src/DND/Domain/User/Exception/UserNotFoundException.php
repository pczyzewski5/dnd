<?php

declare(strict_types=1);

namespace DND\Domain\User\Exception;

use DND\Domain\Exception\ValidationException;

class UserNotFoundException extends ValidationException
{
    public static function notFound(string $id): self
    {
        return new self(
            \sprintf('User with id: %s not found.', $id)
        );
    }
}
