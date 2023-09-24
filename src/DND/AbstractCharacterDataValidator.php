<?php

declare(strict_types=1);

namespace DND;

abstract class AbstractCharacterDataValidator
{
    // @todo doczytać kiedy używa się statików
    protected static string $supportedData = 'data';

    public function supports(string $data): bool
    {
        return static::$supportedData === $data;
    }

    public function validate(string|array $data): void
    {
        if (empty($data)) {
            // @todo change me
            throw new \Exception(static::$supportedData . ' cannot be empty.');
        }
    }
}