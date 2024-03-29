<?php

declare(strict_types=1);

namespace DND\Domain\Validator\Validators;

use DND\Domain\Enum\AbilityEnum;

class StartingAbilitiesValidator extends AbstractCharacterDataValidator
{
    protected static string $supportedData = 'starting_abilities';

    public function validate(array|string $data): void
    {
        if (false === \is_array($data)) {
            // @todo change me
            throw new \Exception(static::$supportedData . ' must be an array.');
        }
        if (empty($data)) {
            // @todo change me
            throw new \Exception(static::$supportedData . ' cannot be empty.');
        }

        $requiredKeys = AbilityEnum::toArray();

        $diff = \array_diff($requiredKeys, \array_keys($data));
        if (false === empty($diff)) {
            // @todo change exception
            $message = \sprintf('Missing keys: %s.', \implode(', ', $diff));
            throw new \Exception($message);
        }

        foreach ($requiredKeys as $requiredKey) {
            if (false === \is_int($data[$requiredKey])) {
                // @todo change me
                throw new \Exception($requiredKey . ' must be an int.');
            }
        }
    }
}