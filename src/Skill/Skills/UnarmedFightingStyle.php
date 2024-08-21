<?php

declare(strict_types=1);

namespace App\Skill\Skills;

class UnarmedFightingStyle extends AbstractSkill
{
    public function getContext(): array
    {
        return [
            'strMod' => $this->character->getAbilities()->getStr()->getModifier()
        ];
    }
}
