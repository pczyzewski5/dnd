<?php

declare(strict_types=1);

namespace App\Calendar\Query;

use App\Entity\User;

class GetCalendarsForUser
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
