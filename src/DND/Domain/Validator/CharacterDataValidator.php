<?php

namespace DND\Domain\Validator;

use DND\Domain\Validator\Validators\AbstractCharacterDataValidator;

class CharacterDataValidator
{
    private const REQUIRED_KEYS = [
        'character_name',
        'player_name',
        'race',
        'alignment',
        'origin',
        'levels',
        'starting_abilities',
        'proficiencies',
        'languages',
        // @todo nie ma validacji zagniezdzoncyh pól
        'proficiencies'
    ];

    /** @var AbstractCharacterDataValidator[] $validators */
    private array $validators = [];

    public function validate(array $data): void
    {
        $this->validateDataHasRequiredKeys($data);

        foreach ($data as $key => $value) {
            foreach ($this->validators as $validator) {
                if ($validator->supports($key)) {
                    $validator->validate($value);
                }
            }
        }
    }

    public function addValidator(AbstractCharacterDataValidator $validator): void
    {
        $this->validators[] = $validator;
    }

    private function validateDataHasRequiredKeys(array $data): void
    {
        if (empty($data)) {
            // @todo change exception
            $message = \sprintf('Missing keys: %', \implode(', ', self::REQUIRED_KEYS));
            throw new \Exception($message );
        }

        $diff = \array_diff(
            self::REQUIRED_KEYS,
            \array_keys($data)
        );

        if (false === empty($diff)) {
            // @todo change exception
            $message = \sprintf('Missing keys: %s.', \implode(', ', $diff));
            throw new \Exception($message);
        }
    }
}