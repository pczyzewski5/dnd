<?php

namespace DND\CharacterClass;

use DND\Character\HitDices;
use DND\Character\Levels;
use DND\Domain\Proficiency\Proficiencies;
use DND\Skill\Skills;

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

    public function getSkills(): Skills
    {
        if (null === $this->characterSubclass) {
            return new Skills($this->characterClass->getSkills());
        }

        $mergedSkills = [];
        $skills = $this->characterClass->getSkills();
        $subclassSkills = $this->characterSubclass->getSkills();

        foreach (\array_keys($skills + $subclassSkills) as $level) {
            $mergedSkills[$level] = \array_merge($skills[$level] ?? [], $subclassSkills[$level] ?? []);
        }

        return new Skills($mergedSkills);
    }

    public function getHitDices(): HitDices
    {
        $hitDices = new HitDices();

        foreach ($this->levels->getLevels() as $level) {
            $levelCharacterClassEnum = $level->getCharacterClassEnum();

            // add for character class
            if ($this->characterClass->getCharacterClassEnum()->equals($levelCharacterClassEnum)) {
                $hitDices->increaseDiceCount($this->characterClass->getHitDiceEnum());
            }
            if (null !== $this->characterClass->getParentCharacterClassEnum()
                && $this->characterClass->getParentCharacterClassEnum()->equals($levelCharacterClassEnum)
            ) {
                $hitDices->increaseDiceCount($this->characterClass->getHitDiceEnum());
            }

            // add for character subclass
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
