<?php

declare(strict_types=1);

namespace App\Encounter;

use function array_key_last;
use function array_map;

class EncounterParticipants
{
    /** @var EncounterParticipant[] */
    private array $participants;

    public function __construct()
    {
        $this->participants = [];
    }

    public function add(EncounterParticipant $participant): self
    {
        $id = array_key_last($this->participants) + 1;
        $this->participants[$id] = $participant->setId($id);

        return $this;
    }

    public function remove(int $participantId): self
    {
        foreach ($this->participants as $key => $participant) {
            if ($participant->getId() === $participantId) {
                unset($this->participants[$key]);
            }
        }

        return $this;
    }

    public function get(int $participantId): EncounterParticipant
    {
        foreach ($this->participants as $participant) {
            if ($participant->getId() === $participantId) {
                return $participant;
            }
        }

        throw new \Exception('Participant not found');
    }

    public function getAll(): array
    {
        return $this->participants;
    }

    public function getIds(): array
    {
        return array_map(
            fn (EncounterParticipant $participant): int => $participant->getId(),
            $this->participants
        );
    }

    public function duplicate(int $participantId): self
    {
        $this->add(
            EncounterParticipantFactory::createFromAnotherParticipant(
                $this->get($participantId)
            )
        );

        return $this;
    }

    public function swap(int $participantId, int $swapId): self
    {
        $participant = $this->get($participantId);
        $participantToSwap = $this->get($swapId);

        $participant->setId($swapId);
        $participantToSwap->setId($participantId);

        $this->participants[$participantId] = $participantToSwap;
        $this->participants[$swapId] = $participant;

        return $this;
    }
}
