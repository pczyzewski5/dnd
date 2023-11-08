<?php

declare(strict_types=1);

namespace DND\Domain\Validator\Validators;

class CharacterNameValidator extends AbstractCharacterDataValidator
{
    protected static string $supportedData = 'character_name';
}