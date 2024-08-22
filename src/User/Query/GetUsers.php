<?php

declare(strict_types=1);

namespace App\User\Query;

use App\User\Entity\User;

class GetUsers
{
    private ?User $excludeUser;

    public function __construct(?User $excludeUser = null)
    {
        $this->excludeUser = $excludeUser;
    }

    public function getExcludeUser(): ?User
    {
        return $this->excludeUser;
    }
}
