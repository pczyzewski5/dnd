<?php

declare(strict_types=1);

namespace App\Validator\Validators;

class PlayerNameValidator extends AbstractCharacterDataValidator
{
    protected static string $supportedData = 'player_name';
}