<?php

declare(strict_types=1);

namespace App\SectionBuilder;

class SkillsCounterSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $context = [
            'skills' => $this->character->skills->withUsageCount()
        ];

        return $this->twig->render(
            'character_card/sections/skills_counter.html.twig',
            $context
        );
    }
}