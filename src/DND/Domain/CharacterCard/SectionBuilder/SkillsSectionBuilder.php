<?php

namespace DND\Domain\CharacterCard\SectionBuilder;

use DND\Domain\Skill\Skills\AbstractSkill;

class SkillsSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $render = function (AbstractSkill $skill) {
            return $this->twig->render(
                $skill->getTemplate(),
                $skill->getContext($this->character)
            );
        };

        $context = [
            'activeSkills' => \array_map($render, $this->character->getActiveSkills()),
            'passiveSkills' => \array_map($render, $this->character->getPassiveSkills())
        ];

        return $this->twig->render(
            'character_card/sections/skills.html.twig',
            $context
        );
    }
}