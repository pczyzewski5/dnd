<?php

declare(strict_types=1);

namespace App\Exception;

use DND\Domain\Exception\ValidationException;

class UserException extends ValidationException
{
    public static function notActive() {
        return new self('User is not activated yet.');
    }
}
