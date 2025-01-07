<?php

declare(strict_types=1);

namespace App\Builder\SkillBuilder;

use App\Character\Skill;
use App\Character\SkillFactory;

class MysticWisdom extends AbstractSkillFinisher
{
    public function supports(Skill $skill): bool
    {
        return 'mystic wisdom' === $skill->name;
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
