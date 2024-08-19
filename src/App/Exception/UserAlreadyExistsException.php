<?php

declare(strict_types=1);

namespace App\Exception;

use DND\Domain\Exception\ValidationException;

class UserAlreadyExistsException extends ValidationException
{

}
