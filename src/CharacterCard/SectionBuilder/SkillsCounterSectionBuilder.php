<?php

declare(strict_types=1);

namespace App\CharacterCard\SectionBuilder;

class SkillsCounterSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        return $this->twig->render(
            'character_card/sections/skills_counter.html.twig',[
            'skills' => $this->character->getSkills()->getSkillsWithUseCount(),
        ]);
    }
}