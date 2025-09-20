<?php

declare(strict_types=1);

namespace App\Builder\SkillBuilder;

use App\Character\Skill;
use App\Character\SkillFactory;

class WrathOfTheStorm extends AbstractSkillFinisher
{
    public function supports(Skill $skill): bool
    {
        return 'wrath of the storm' === $skill->name;
    }

    public function finish(Skill $skill): Skill
    {
        $count = $this->abilities->wis->modifier;

        $description = $this->replacePlaceholders(
            ['count' => $count],
            $skill->description
        );

        return SkillFactory::create(
            $skill->name,
            $description,
            $count
        );
    }
}
