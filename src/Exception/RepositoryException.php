<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Uid\Uuid;

class RepositoryException extends \Exception
{
    public static function notFound(string $name, Uuid $uuid): self
    {
        return new self(
            \sprintf('%s with id: %s not found.', $name, $uuid->toRfc4122())
        );
    }
}
