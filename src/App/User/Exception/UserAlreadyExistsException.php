<?php

declare(strict_types=1);

namespace App\User\Exception;

use DND\Domain\Exception\ValidationException;

class UserAlreadyExistsException extends ValidationException
{

}
