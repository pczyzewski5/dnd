<?php

declare(strict_types=1);

namespace DND\Domain\Query;

use App\User\User;

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
