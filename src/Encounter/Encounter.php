<?php

declare(strict_types=1);

namespace App\Encounter;

class Encounter
{
    /** @var EncounterParticipant[] */
    private EncounterParticipants $participants;

    public function __construct()
    {
        $this->participants = new EncounterParticipants();
    }

    public function getParticipants(): EncounterParticipants
    {
        return $this->participants;
    }
}
