<?php

declare(strict_types=1);

namespace App\Collection;

use Countable;
use Iterator;

class Collection implements Iterator, Countable
{
    private array $items;
    private int $position;

    public function __construct()
    {
        $this->items = [];
        $this->position = 0;
    }

    protected function addItem(mixed ...$items): self
    {
        $this->items[] = $items;

        return $this;
    }

    public function current(): mixed
    {
        return $this->items[$this->position];
    }

    public function rewind(): void
    {
        $this->position = 0;
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
            $this->items[$this->position]
        );
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }
}
