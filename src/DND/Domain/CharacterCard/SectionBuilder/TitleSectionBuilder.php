<?php

declare(strict_types=1);

namespace DND\Domain\CharacterCard\SectionBuilder;

class TitleSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $className = \ucwords(
            $this->character->getCharacterClassCollection()->getMainClassName()
        );

        $subclassName = $this->character->getCharacterClassCollection()->getSubclassName();
        if (null !== $subclassName) {
            $className .= ' - ' . \ucwords($subclassName);
        }

        return $this->twig->render(
            'character_card/sections/title.html.twig', [
            'className' => $className,
            'level' => $this->character->getLevels()->getLevel(),
            'origin' => $this->character->getOrigin(),
            'characterName' => $this->character->getCharacterName(),
            'playerName' => $this->character->getPlayerName(),
            'race' => $this->character->getRace()->getName(),
            'alignment' => $this->character->getAlignment()->getValue(),
            'campaign' => $this->character->getCampaignName(),
        ]);
    }
}