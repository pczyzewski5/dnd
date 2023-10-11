<?php

namespace DND\CharacterClass;

use DND\Character\HitDices;
use DND\Character\Levels;
use DND\Domain\Proficiency\Proficiencies;

class CharacterClassHelper
{
    public Levels $levels;
    public CharacterClass $characterClass;
    public ?CharacterClass $characterSubclass;

    public function __construct(Levels $levels)
    {
        $this->levels = $levels;
        $this->characterClass = CharacterClassResolver::getCharacterClass($levels);
        $this->characterSubclass = CharacterClassResolver::getCharacterSubclass($levels);
    }

    public function getCharacterClass(): CharacterClass
    {
        return $this->characterClass;
    }

    public function getCharacterSubclass(): ?CharacterClass
    {
        return $this->characterSubclass;
    }

    public function getProficiencies(): Proficiencies
    {
        return $this->characterClass->getProficiencies();
    }

    public function getSkills()
    {

    }

    public function getHitDices(): HitDices
    {
        $hitDices = new HitDices();

        foreach ($this->levels->getLevels() as $level) {
            $levelCharacterClassEnum = $level->getCharacterClassEnum();

            if ($this->characterClass->getCharacterClassEnum()->equals($levelCharacterClassEnum)) {
                $hitDices->increaseDiceCount($this->characterClass->getHitDiceEnum());
            }
            if (null !== $this->characterClass->getParentCharacterClassEnum()
                && $this->characterClass->getParentCharacterClassEnum()->equals($levelCharacterClassEnum)
            ) {
                $hitDices->increaseDiceCount($this->characterClass->getHitDiceEnum());
            }

            if (null !== $this->characterSubclass) {
                if ($this->characterSubclass->getCharacterClassEnum()->equals($levelCharacterClassEnum)) {
                    $hitDices->increaseDiceCount($this->characterSubclass->getHitDiceEnum());
                }
                if (null !== $this->characterSubclass->getParentCharacterClassEnum()
                    && $this->characterSubclass->getParentCharacterClassEnum()->equals($levelCharacterClassEnum)
                ) {
                    $hitDices->increaseDiceCount($this->characterSubclass->getHitDiceEnum());
                }
            }
        }

        return $hitDices;
    }
}
