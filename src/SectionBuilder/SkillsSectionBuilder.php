<?php

declare(strict_types=1);

namespace App\SectionBuilder;

class SkillsSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        return $this->twig->render(
            'character_card/new_sections/skills.html.twig', [
            'activeSkills' => [],
            'passiveSkills' => []
        ]);
    }
}