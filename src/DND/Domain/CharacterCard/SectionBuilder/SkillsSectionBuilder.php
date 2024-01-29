<?php

declare(strict_types=1);

namespace DND\Domain\CharacterCard\SectionBuilder;

use DND\Domain\Skill\Skills\AbstractSkill;

class SkillsSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
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