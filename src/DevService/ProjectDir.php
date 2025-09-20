<?php

namespace App\DevService;

class ProjectDir
{
    public function __construct(private readonly string $projectDir)
    {
    }

    public function __toString(): string
    {
        return $this->projectDir;
    }
}
