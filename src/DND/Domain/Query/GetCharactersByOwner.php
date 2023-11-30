<?php

declare(strict_types=1);

namespace DND\Domain\Query;

use DND\Domain\User\User;

class GetCharactersByOwner
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
