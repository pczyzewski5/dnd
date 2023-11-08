<?php

declare(strict_types=1);

namespace DND\Domain\Validator\Validators;

use DND\Domain\Enum\LanguageEnum;

class LanguageValidator extends AbstractCharacterDataValidator
{
    protected static string $supportedData = 'languages';

    public function validate(array|string $data): void
    {
        if (false === \is_array($data)) {
            // @todo change me
            throw new \Exception(static::$supportedData . ' must be an array.');
        }

        $notSupportedLanguages = [];
        foreach ($data as $language) {
            if (false === LanguageEnum::isValid($language)) {
                $notSupportedLanguages[] = $language;
            }
        }

        if (false === empty($notSupportedLanguages)) {
            // @todo change me
            throw new \Exception('Provided languages are not supported: ' . \implode(', ', $notSupportedLanguages) . '.');
        }
    }
}