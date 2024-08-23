<?php

declare(strict_types=1);

namespace App\Encounter;

class EncounterParticipant
{
    private int $id;
    private string $name;
    private int $armorClass;
    private int $maxHp;
    private int $actualHp;
    private int $speed;
    private string $image;
    private int $lastHpChange;

    public function __construct(
        string $name,
        int $armorClass,
        int $maxHp,
        int $speed,
        string $image
    ) {
        $this->name = $name;
        $this->armorClass = $armorClass;
        $this->maxHp = $maxHp;
        $this->speed = $speed;
        $this->image = $image;

        $this->actualHp = $maxHp;
        $this->lastHpChange = 0;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getArmorClass(): int
    {
        return $this->armorClass;
    }

    public function getMaxHp(): int
    {
        return $this->maxHp;
    }

    public function getActualHp(): int
    {
        return max($this->actualHp, 0);
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function addHp(int $hp): self
    {
        $this->actualHp += $hp;

        $this->lastHpChange = $hp;

        return $this;
    }

    public function removeHp(int $hp): self
    {
        $this->actualHp = max(
            $this->actualHp -= $hp,
            0
        );

        $this->lastHpChange = -1 * abs($hp);

        return $this;
    }

    public function rollbackLastHpChange(): void
    {
        $lastHpChange = $this->lastHpChange;

        if ($lastHpChange === 0) {
            return;
        }

        $lastHpChange > 0
            ? $this->removeHp(abs($this->lastHpChange))
            : $this->addHp(abs($this->lastHpChange));

        $this->lastHpChange = 0;
    }

    public function isDead(): bool
    {
        return $this->getActualHp() === 0;
    }
}
