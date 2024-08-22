<?php

declare(strict_types=1);

namespace App\Skill\Skills;

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
