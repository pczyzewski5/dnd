<?php

declare(strict_types=1);

namespace DND\Domain\Query;

use App\User\User;

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
