<?php

declare(strict_types=1);

namespace DND\Domain\ItemCard\Exception;

use DND\Domain\Exception\ValidationException;

class ItemCardNotFoundException extends ValidationException
{
    public static function notFound(string $id): self
    {
        return new self(
            \sprintf('Item card with id: %s not found.', $id)
        );
    }
}
