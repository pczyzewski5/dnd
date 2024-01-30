<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use DND\Domain\CharacterClass\CharacterClassHelper;
use DND\Domain\Enum\CharacterClassEnum;
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
        foreach ($this->character->getCharacterClassCollection()->getCharacterClasses() as $characterClass) {
            $characterClassEnum = $characterClass->getCharacterClassEnum();
            if (CharacterClassHelper::isArchetype($characterClassEnum)) {
                $characterClassEnum = CharacterClassHelper::getBaseClass($characterClassEnum);
            }

            if ($characterClassEnum->getValue() === CharacterClassEnum::BARBARIAN) {
                $barbarianLevel = $characterClass->getLevel();
                break;
            }
        }

        return self::RAGE_LEVELS[$barbarianLevel]['count'];
    }

    public function getContext(): array
    {
        return [
            'damage' => self::RAGE_LEVELS[$this->character->getLevels()->getLevel()]['damage']
        ];
    }
}
