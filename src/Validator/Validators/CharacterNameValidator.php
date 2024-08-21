<?php

declare(strict_types=1);

namespace App\Validator\Validators;

class CharacterNameValidator extends AbstractCharacterDataValidator
{
    protected static string $supportedData = 'character_name';
}