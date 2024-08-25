<?php

declare(strict_types=1);

namespace App\Encounter;

use function abs;
use function array_key_last;
use function max;

class EncounterParticipantHp
{
    private int $maxHp;
    private int $actualHp;
    private array $hpHistory;

    public function __construct(int $maxHp)
    {
        $this->maxHp = $maxHp;

        $this->actualHp = $this->maxHp;
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

        if (0 === $hp) {
            return $this;
        }

        $this->actualHp += $hp;
        $this->hpHistory[] = $hp;

        return $this;
    }

    public function remove(int $hp): self
    {
        $hp = -1 * abs($hp);

        if (0 === $hp) {
            return $this;
        }

        $this->actualHp = max(0, $this->actualHp += $hp);
        $this->hpHistory[] = $hp;

        return $this;
    }

    public function rollbackLastChange(): self
    {
        if (empty($this->hpHistory)) {
            return $this;
        }

        $lastHpChange = end($this->hpHistory);

        unset($this->hpHistory[
            array_key_last($this->hpHistory)
            ]);

        $lastHpChange > 0
            ? $this->remove($lastHpChange)
            : $this->add($lastHpChange);

        unset($this->hpHistory[
            array_key_last($this->hpHistory)
            ]);

        return $this;
    }

    public function isDead(): bool
    {
        return $this->getActual() === 0;
    }
}
