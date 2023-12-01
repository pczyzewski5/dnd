<?php

declare(strict_types=1);

namespace DND\Domain\Query;

use DND\Domain\User\User;

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
