<?php

declare(strict_types=1);

namespace App\Skill\Skills;

class NaturalArmor extends AbstractSkill
{
    public function getContext(): array
    {
        return [
            'ac' => $this->character->getAbilities()->getDex()->getModifier() + 13
        ];
    }
}
