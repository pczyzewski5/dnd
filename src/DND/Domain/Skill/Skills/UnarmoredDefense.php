<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\CharacterClassEnum;

class UnarmoredDefense extends AbstractSkill
{
    public function getContext(): array
    {
        return [
            'ac' => $this->character->getAbilities()->getDex()->getModifier()
                + $this->character->getAbilities()->getCon()->getModifier()
                + 10
        ];
    }
}
