<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

class UnarmedFightingStyle extends AbstractSkill
{
    public function getContext(): array
    {
        return [
            'strMod' => $this->character->getAbilities()->getStr()->getModifier()
        ];
    }
}
