<?php

declare(strict_types=1);

namespace App\Encounter;

use function abs;
use function max;

class EncounterParticipantHp
{
    private int $maxHp;
    private int $actualHp;
    private array $hpHistory;
    private int $lastHpChange;

    public function __construct(int $maxHp)
    {
        $this->maxHp = $maxHp;

        $this->actualHp = $this->maxHp;
        $this->lastHpChange = 0;
        $this->hpHistory = [];
    }

    public function getMax(): int
    {
        return $this->maxHp;
    }

    public function getActual(): int
    {
        return max($this->actualHp, 0);
    }

    public function getHistory(): array
    {
        return $this->hpHistory;
    }

    public function add(int $hp): self
    {
        $this->actualHp += $hp;

        $this->lastHpChange = $hp;
        $this->hpHistory[] = $this->lastHpChange;

        return $this;
    }

    public function remove(int $hp): self
    {
        $this->actualHp = max(
            $this->actualHp -= $hp,
            0
        );

        $this->lastHpChange = -1 * abs($hp);
        $this->hpHistory[] = $this->lastHpChange;

        return $this;
    }

    public function rollbackLastChange(): self
    {
        $lastHpChange = $this->lastHpChange;

        if ($lastHpChange === 0) {
            return $this;
        }

        $lastHpChange > 0
            ? $this->remove(abs($this->lastHpChange))
            : $this->add(abs($this->lastHpChange));

        $this->lastHpChange = 0;

        return $this;
    }

    public function isDead(): bool
    {
        return $this->getActual() === 0;
    }
}
