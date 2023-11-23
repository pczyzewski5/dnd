<?php

declare(strict_types=1);

namespace DND\Domain\User\Exception;

use DND\Domain\Exception\ValidationException;

class UserAlreadyExistsException extends ValidationException
{

}
