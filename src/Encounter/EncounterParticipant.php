<?php

declare(strict_types=1);

namespace App\Encounter;

class EncounterParticipant
{
    private int $id;
    private string $name;
    private int $ac;
    private int $speed;
    private string $image;
    private EncounterParticipantHp $encounterParticipantHp;
    private string $note;

    public function __construct(
        string $name,
        int $ac,
        int $speed,
        string $image,
        EncounterParticipantHp $hp,
    ) {
        $this->name = $name;
        $this->ac = $ac;
        $this->speed = $speed;
        $this->image = $image;
        $this->encounterParticipantHp = $hp;

        $this->note = '';
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

    public function getAc(): int
    {
        return $this->ac;
    }
    
    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getHp(): EncounterParticipantHp
    {
        return $this->encounterParticipantHp;
    }
    
    public function getNote(): string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }
}
