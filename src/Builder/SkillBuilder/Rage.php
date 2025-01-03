<?php

declare(strict_types=1);

namespace App\Builder\SkillBuilder;

use App\Character\Skill;
use App\Character\SkillFactory;

class Rage extends AbstractSkillFinisher
{
    private const RAGE_LEVELS = [
        1 => ['count' => 2, 'damage' => 2],
        2 => ['count' => 2, 'damage' => 2],
        3 => ['count' => 3, 'damage' => 2],
        4 => ['count' => 3, 'damage' => 2],
        5 => ['count' => 3, 'damage' => 2],
        6 => ['count' => 4, 'damage' => 2],
        7 => ['count' => 4, 'damage' => 2],
        8 => ['count' => 4, 'damage' => 2],
        9 => ['count' => 4, 'damage' => 3],
        10 => ['count' => 4, 'damage' => 3],
    ];

    public function supports(Skill $skill): bool
    {
        return 'rage' === $skill->name;
    }

    public function finish(Skill $skill): Skill
    {
        $count =  self::RAGE_LEVELS[$this->level]['count'];
        $damage = self::RAGE_LEVELS[$this->level]['damage'];
        $resistances = $this->hasSkill('bear spirit totem')
            ? 'otrzymujesz połowę obrażeń każdego typu - prócz psychicznych'
            : 'otrzymujesz połowę obrażeń: siecznych, obuchowych oraz przebijających';

        $description = $this->replacePlaceholders(
            ['damage' => $damage, 'resistances' => $resistances],
            $skill->description
        );

        return SkillFactory::create(
            $skill->name,
            $description,
            $count
        );
    }
}
