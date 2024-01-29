<?php

declare(strict_types=1);

namespace DND\Domain\CharacterCard\SectionBuilder;

class TitleSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context =  [
            'className' => $this->character->getCharacterClassFullName(),
            'level' => $this->character->getLevels()->getLevel(),
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