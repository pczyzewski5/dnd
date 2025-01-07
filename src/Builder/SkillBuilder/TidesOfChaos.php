<?php

declare(strict_types=1);

namespace App\Builder\SkillBuilder;

use App\Character\Skill;
use App\Character\SkillFactory;

class TidesOfChaos extends AbstractSkillFinisher
{
    public function supports(Skill $skill): bool
    {
        return 'tides of chaos' === $skill->name;
    }

    public function finish(Skill $skill): Skill
    {
        return SkillFactory::create(
            $skill->name,
            $skill->description,
            1
        );
    }
}
