<?php

namespace DND\CharacterCard\SectionBuilder;

class HitDiceSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $hitDices = $this->character->getHitDices()->toArray();

        $classHitDiceType = 'D' . $hitDices[0]['type'];
        $classHitDiceCount = $hitDices[0]['count'];

        $subclassHitDiceCount = null;
        $subclassHitDiceType = null;
        if (\count($hitDices) === 2) {
            $subclassHitDiceType = 'D' . $hitDices[1]['type'];
            $subclassHitDiceCount = $hitDices[1]['count'];
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