<?php

declare(strict_types=1);

namespace DND\Validators;

use DND\Domain\Enum\Origin;

class OriginValidator extends AbstractCharacterDataValidator
{
    protected static string $supportedData = 'origin';

    public function validate(array|string $data): void
    {
        if (false === \is_string($data)) {
            // @todo change me
            throw new \Exception(static::$supportedData . ' must be a string.');
        }
        if (empty($data)) {
            // @todo change me
            throw new \Exception(static::$supportedData . ' cannot be empty.');
        }
        if (false === Origin::isValid($data)) {
            // @todo change me
            throw new \Exception(
                'Provided origin is not supported. Supported are: ' . \implode(', ', Origin::toArray()) . '.'
            );
        }
    }
}