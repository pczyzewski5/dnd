<?php

declare(strict_types=1);

namespace App\Collection;

use App\Entity\Level;
use Iterator;

class Levels implements Iterator
{
    private array $levels;
    private int $position;

    public function __construct()
    {
        $this->levels = [];
        $this->position = 0;
    }

    public function add(Level $level): self
    {
        $this->levels[] = $level;

        return $this;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current(): Level
    {
        return $this->levels[$this->position];
    }

    public function key(): mixed
    {
        return $this->position;
    }

    public function next(): void
    {
        $this->position++;
    }

    public function valid(): bool
    {
        return isset(
            $this->levels[$this->position]
        );
    }

    public function toArray(): array
    {
        return $this->levels;
    }
}
