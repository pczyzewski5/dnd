<?php

declare(strict_types=1);

namespace DND\Domain\Validator\Validators;

use DND\Domain\Enum\AlignmentEnum;

class AlignmentValidator extends AbstractCharacterDataValidator
{
    protected static string $supportedData = 'alignment';

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
        if (false === AlignmentEnum::isValid($data)) {
            // @todo change me
            throw new \Exception(
                'Provided alignment is not supported. Supported are: ' . \implode(', ', AlignmentEnum::toArray()) . '.'
            );
        }
    }
}