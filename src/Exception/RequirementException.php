<?php

declare(strict_types=1);

namespace App\Exception;

use function sprintf;

class RequirementException extends \Exception
{
    public static function requirementNotMet(string $message): self
    {
        return new self(
            sprintf('Requirements not met. %s', $message)
        );
    }
}
