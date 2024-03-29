<?php

declare(strict_types=1);

namespace DND\Domain\Validator\Validators;

use DND\Domain\Enum\ProficiencyEnum;

class ProficiencyValidator extends AbstractCharacterDataValidator
{
    protected static string $supportedData = 'proficiencies';

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

        $notSupportedProficiencies = [];
        foreach ($data as $proficiency) {
            if (false === ProficiencyEnum::isValid($proficiency)) {
                $notSupportedProficiencies[] = $proficiency;
            }
        }

        if (false === empty($notSupportedProficiencies)) {
            // @todo change me
            throw new \Exception('Provided proficiencies are not supported: ' . \implode(', ', $notSupportedProficiencies) . '.');
        }
    }
}