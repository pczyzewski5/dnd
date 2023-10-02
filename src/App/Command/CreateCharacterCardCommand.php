<?php

namespace App\Command;

use DND\Character\CharacterFactory;
use DND\CharacterCard\CharacterCardBuilder;
use DND\CharacterDataValidator;
use DND\Validators\AlignmentValidator;
use DND\Validators\CharacterNameValidator;
use DND\Validators\LanguageValidator;
use DND\Validators\OriginValidator;
use DND\Validators\PlayerNameValidator;
use DND\Validators\RaceValidator;
use DND\Validators\StartingAbilitiesValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCharacterCardCommand extends Command
{
    private const COMMAND_NAME = 'dnd:create-character-card';

    private CharacterCardBuilder $characterCardBuilder;

    public function __construct(CharacterCardBuilder $characterCardBuilder)
    {
        parent::__construct(self::COMMAND_NAME);

        $this->characterCardBuilder = $characterCardBuilder;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $character = CharacterFactory::createFromArray(
            $this->getValidData()
        );

        \file_put_contents(
            'character_card.html',
            $this->characterCardBuilder->build($character)
        );

        return Command::SUCCESS;
    }

    private function getValidData(): array
    {
        $data = \json_decode(
            \file_get_contents('mordimer.json'),
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
        $characterDataValidator->addValidator(new StartingAbilitiesValidator());
        $characterDataValidator->addValidator(new OriginValidator());
        $characterDataValidator->addValidator(new LanguageValidator());

        $characterDataValidator->validate($data);

        return $data;
    }
}
