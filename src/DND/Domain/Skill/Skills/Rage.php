<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Enum\SkillEnum;
use DND\Domain\Enum\SkillTagEnum;

class Rage extends AbstractSkill
{
    protected const ORDER = 0;
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
        SkillTagEnum::USE_COUNT,
    ];

    private const RAGE_LEVELS = [
        1 => ['count' => 2, 'damage' => 2],
        2 => ['count' => 2, 'damage' => 2],
        3 => ['count' => 3, 'damage' => 2],
        4 => ['count' => 3, 'damage' => 2],
        5 => ['count' => 3, 'damage' => 2],
        6 => ['count' => 4, 'damage' => 2],
        7 => ['count' => 4, 'damage' => 2],
        8 => ['count' => 4, 'damage' => 2],
        9 => ['count' => 4, 'damage' => 3],
        10 => ['count' => 4, 'damage' => 3],
    ];

    public function getUsageCount(): int
    {
        $level = $this->character->getCharacterClassCollection()->getClassLevel(
            CharacterClassEnum::BARBARIAN()
        );

        return self::RAGE_LEVELS[$level]['count'];
    }

    public function getContext(): array
    {
        $level = $this->character->getCharacterClassCollection()->getClassLevel(
            CharacterClassEnum::BARBARIAN()
        );

        $resistances = 'otrzymujesz połowę obrażeń: siecznych, obuchowych oraz przebijających';
        if ($this->character->getSkills()->hasSkill(SkillEnum::BEAR_SPIRIT_TOTEM)) {
            $resistances = 'otrzymujesz połowę obrażeń każdego typu - prócz psychicznych';
        }

        return [
            'damage' => self::RAGE_LEVELS[$level]['damage'],
            'resistances' => $resistances
        ];
    }
}
