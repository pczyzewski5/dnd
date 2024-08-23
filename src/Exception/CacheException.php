<?php

declare(strict_types=1);

namespace App\Exception;

class CacheException extends \Exception
{
    public static function keyNotFound(string $key): self
    {
        return new self(
            \sprintf('Key: %s, not found in cache.', $key)
        );
    }
}
