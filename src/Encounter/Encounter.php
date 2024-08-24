<?php

declare(strict_types=1);

namespace App\Encounter;

use function array_key_last;

class Encounter
{
    /** @var EncounterParticipant[] */
    private array $participants;

    public function __construct()
    {
        $this->participants = [];
    }

    public function addParticipant(EncounterParticipant $participant): self
    {
        $id = array_key_last($this->participants) + 1;
        $this->participants[$id] = $participant->setId($id);

        return $this;
    }

    public function removeParticipant(int $participantId): self
    {
        foreach ($this->participants as $key => $participant) {
            if ($participant->getId() === $participantId) {
                unset($this->participants[$key]);
            }
        }

        return $this;
    }

    public function duplicateParticipant(int $participantId): self
    {
        foreach ($this->participants as $participant) {
            if ($participant->getId() === $participantId) {
                $this->addParticipant(
                    EncounterParticipantFactory::createFromAnotherParticipant($participant)
                );
                break;
            }
        }

        return $this;
    }

    public function getParticipants(): array
    {
        return $this->participants;
    }

    public function addHp(int $participantId, int $hp): self
    {
        foreach ($this->participants as $participant) {
            if ($participant->getId() === $participantId) {
                $participant->addHp($hp);
            }
        }

        return $this;
    }

    public function removeHp(int $participantId, int $hp): self
    {
        foreach ($this->participants as $participant) {
            if ($participant->getId() === $participantId) {
                $participant->removeHp($hp);
            }
        }

        return $this;
    }

    public function rollbackLastHpChange(int $participantId): self
    {
        foreach ($this->participants as $participant) {
            if ($participant->getId() === $participantId) {
                $participant->rollbackLastHpChange();
            }
        }

        return $this;
    }

    public function addNote(int $participantId, string $note): self
    {
        foreach ($this->participants as $participant) {
            if ($participant->getId() === $participantId) {
                $participant->setNote($note);
            }
        }

        return $this;
    }
}
