<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

class BonusLanguage extends AbstractSkill
{
    public function getContext(): array
    {
        return [
            'language' => 'uzupłenij mnie'
        ];
    }
}
