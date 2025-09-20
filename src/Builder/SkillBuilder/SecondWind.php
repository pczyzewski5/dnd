<?php

declare(strict_types=1);

namespace App\Builder\SkillBuilder;

use App\Character\Skill;
use App\Character\SkillFactory;

class SecondWind extends AbstractSkillFinisher
{

    public function supports(Skill $skill): bool
    {
        return 'second wind' === $skill->name;
    }

    public function finish(Skill $skill): Skill
    {
        $description = $this->replacePlaceholders(
            ['level' => count($this->levels)],
            $skill->description
        );

        return SkillFactory::create(
            $skill->name,
            $description,
            1
        );
    }
}
