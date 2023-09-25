<?php

namespace DND\Character;

use DND\Domain\Enum\Alignment;
use DND\Domain\Enum\Origin;
use DND\Domain\Enum\Race;

class Character
{
    private string $characterName;
    private string $playerName;
    private Race $race;
    private Origin $origin;
    private Alignment $alignment;
    private Level $level;

    public function __construct(
        string $characterName,
        string $playerName,
        Race $race,
        Origin $origin,
        Alignment $alignment,
        Level $level
    ) {
        $this->characterName = $characterName;
        $this->playerName = $playerName;
        $this->race = $race;
        $this->origin = $origin;
        $this->alignment = $alignment;
        $this->level = $level;
    }

    public function getCharacterName(): string
    {
        return $this->characterName;
    }

    public function getPlayerName(): string
    {
        return $this->playerName;
    }

    public function getRace(): Race
    {
        return $this->race;
    }

    public function getOrigin(): Origin
    {
        return $this->origin;
    }

    public function getAlignment(): Alignment
    {
        return $this->alignment;
    }

    public function getLevel(): Level
    {
        return $this->level;
    }
}