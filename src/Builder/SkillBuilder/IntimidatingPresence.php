<?php

declare(strict_types=1);

namespace App\Builder\SkillBuilder;

use App\Character\Skill;
use App\Character\SkillFactory;

class IntimidatingPresence extends AbstractSkillFinisher
{

    public function supports(Skill $skill): bool
    {
        return 'intimidating presence' === $skill->name;
    }

    public function finish(Skill $skill): Skill
    {
        $wisDc = 8 + $this->proficiencyBonus + $this->abilities->cha->modifier;

        $description = $this->replacePlaceholders(
            ['wisDc' => $wisDc],
            $skill->description
        );

        return SkillFactory::create(
            $skill->name,
            $description
        );
    }
}
