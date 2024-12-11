<?php

declare(strict_types=1);

namespace App\CharacterCard\SectionBuilder;

use App\Skill\Skills\AbstractSkill;

class SkillsSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $render = function (AbstractSkill $skill): string {
            return $this->twig->render(
                $skill->getTemplate(),
                $skill->getContext()
            );
        };

        return $this->twig->render(
            'character_card/sections/skills.html.twig', [
            'activeSkills' => \array_map($render, $this->character->getSkills()->getActiveSkills()),
            'passiveSkills' => \array_map($render, $this->character->getSkills()->getPassiveSkills())
        ]);
    }
}