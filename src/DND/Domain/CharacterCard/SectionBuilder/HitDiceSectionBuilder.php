<?php

namespace DND\Domain\CharacterCard\SectionBuilder;

class HitDiceSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $classHitDiceType = null;
        $classHitDiceCount = null;
        $subclassHitDiceType = null;
        $subclassHitDiceCount = null;

        foreach ($this->character->getHitDices() as $type => $count) {
            if (null === $classHitDiceType) {
                $classHitDiceType = $type;
                $classHitDiceCount = $count;
            } else {
                $subclassHitDiceType = $type;
                $subclassHitDiceCount = $count;
            }
        }

        $context =  [
            'classHitDiceCount' => $classHitDiceCount,
            'classHitDiceType' => $classHitDiceType,
            'subclassHitDiceCount' => $subclassHitDiceCount,
            'subclassHitDiceType' => $subclassHitDiceType,
        ];

        return $this->twig->render(
            'character_card/sections/hit_dice.html.twig',
            $context
        );
    }
}