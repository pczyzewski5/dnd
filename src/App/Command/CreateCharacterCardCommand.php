<?php

namespace App\Command;

use DND\Calculators\ProficiencyBonusCalculator;
use DND\Character\CharacterFactory;
use DND\Calculators\HpCalculator;
use DND\CharacterDataValidator;
use DND\Validators\AlignmentValidator;
use DND\Validators\CharacterNameValidator;
use DND\Validators\LanguageValidator;
use DND\Validators\OriginValidator;
use DND\Validators\PlayerNameValidator;
use DND\Validators\RaceValidator;
use DND\Validators\StartingStatsValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCharacterCardCommand extends Command
{
    private const COMMAND_NAME = 'dnd:create-character-card';

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $character = CharacterFactory::createFromArray($this->getValidData());
        $content = \file_get_contents('template.html');
        $data = [
            '$characterName' => $character->getCharacterName(),
            '$playerName' => $character->getPlayerName(),
            '$race' => $character->getRace(),
            '$alignment' => $character->getAlignment(),
            '$origin' => $character->getOrigin(),
            '$classLevel' => $character->getLevel()->getClass() . ' ' .$character->getLevel()->getLevel(),
            '$hp' => HpCalculator::calculate($character),
            '$proficiencyBonus' => ProficiencyBonusCalculator::calculate($character->getLevel()->getLevel())
        ];

        $content = \str_replace(
            \array_keys($data),
            \array_values($data),
            $content
        );

        \file_put_contents('character_card.html', $content);

        return Command::SUCCESS;
    }

    private function getValidData(): array
    {
        $data = \json_decode(
            \file_get_contents('sydda.json'),
            true
        );
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('invalid character data json');
        }

        $characterDataValidator = new CharacterDataValidator();
        $characterDataValidator->addValidator(new PlayerNameValidator());
        $characterDataValidator->addValidator(new CharacterNameValidator());
        $characterDataValidator->addValidator(new RaceValidator());
        $characterDataValidator->addValidator(new AlignmentValidator());
        $characterDataValidator->addValidator(new StartingStatsValidator());
        $characterDataValidator->addValidator(new OriginValidator());
        $characterDataValidator->addValidator(new LanguageValidator());

        $characterDataValidator->validate($data);

        return $data;
    }
}
