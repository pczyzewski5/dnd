<?php

declare(strict_types=1);

namespace DND;

class PlayerNameValidator extends AbstractCharacterDataValidator
{
    protected static string $supportedData = 'player_name';
}