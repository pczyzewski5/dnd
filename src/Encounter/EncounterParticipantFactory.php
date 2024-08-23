<?php

declare(strict_types=1);

namespace App\Encounter;

use App\Monster\Entity\Monster;

class EncounterParticipantFactory
{
    public static function createFromMonster(Monster $monster): EncounterParticipant
    {
        return new EncounterParticipant(
            $monster->getName(),
            $monster->getArmorClass(),
            $monster->getMaxHp(),
            10,
            $monster->getImage()
        );
    }

    public static function createFromAnotherParticipant(EncounterParticipant $participant): EncounterParticipant
    {
        return new EncounterParticipant(
            $participant->getName(),
            $participant->getArmorClass(),
            $participant->getMaxHp(),
            10,
            $participant->getImage()
        );
    }
}
