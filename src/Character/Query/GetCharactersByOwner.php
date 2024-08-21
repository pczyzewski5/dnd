<?php

declare(strict_types=1);

namespace App\Character\Query;

use App\User\Entity\User;

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
