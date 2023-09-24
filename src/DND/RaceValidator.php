<?php

declare(strict_types=1);

namespace DND;

use DND\Domain\Enum\Race;

class RaceValidator extends AbstractCharacterDataValidator
{
    protected static string $supportedData = 'race';

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
        if (false === Race::isValid($data)) {
            // @todo change me
            throw new \Exception(
                'Provided race is not supported. Supported are: ' . \implode(', ', Race::toArray()) . '.'
            );
        }
    }
}