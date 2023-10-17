<?php

namespace DND\CharacterCard\SectionBuilder;

use DND\Character\Character;

class TitleSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $className = \ucfirst($this->character->getCharacterClass()->getName());
        if (null !== $characterSubclass = $this->character->getCharacterSubclass()) {
            $className .= '-' . \ucfirst($characterSubclass->getName());
        }

        $context =  [
            'className' => $className,
            'level' => $this->character->getActualLevel(),
            'origin' => $this->character->getOrigin(),
            'characterName' => $this->character->getCharacterName(),
            'playerName' => $this->character->getPlayerName(),
            'race' => $this->character->getRace()->getName(),
            'alignment' => $this->character->getAlignment()->getValue(),
            'campaign' => $this->character->getCampaignName(),
        ];

        return $this->twig->render(
            'character_card/sections/title.html.twig',
            $context
        );
    }
}