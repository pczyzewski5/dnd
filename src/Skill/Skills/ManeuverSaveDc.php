<?php

declare(strict_types=1);

namespace App\Skill\Skills;

class ManeuverSaveDc extends AbstractSkill
{
    public function getContext(): array
    {
        return ['dc' => 8 + $this->character->getProficiencyBonus() + $this->character->getAbilities()->getStr()->getModifier()];
    }
}
