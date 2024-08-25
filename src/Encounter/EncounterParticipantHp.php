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
        return array_map(static function(int $value): string {
            return $value > 0 ? '+' . $value : (string)$value;
        }, $this->hpHistory);
    }

    public function add(int $hp): self
    {
        $hp = abs($hp);

        $this->actualHp += $hp;
        $this->lastHpChange = $hp;
        $this->hpHistory[] = $hp;

        return $this;
    }

    public function remove(int $hp): self
    {
        $hp = -1 * abs($hp);

        $this->actualHp = max(0, $this->actualHp += $hp);
        $this->hpHistory[] = $hp;

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
