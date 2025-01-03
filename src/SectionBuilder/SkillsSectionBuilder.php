<?php

declare(strict_types=1);

namespace App\SectionBuilder;

use function var_dump;

class SkillsSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $context = [
            'skills' => $this->character->skills->all()
        ];

        return $this->twig->render(
            'character_card/sections/skills.html.twig',
            $context
        );
    }
}