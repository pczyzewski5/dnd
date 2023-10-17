<?php

namespace App\Command;

use App\CaseConverter;
use DND\Character\Character;
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
    private const CHARACTER_JSON_DIR = 'input/';
    private const OUTPUT_DIR = 'output/';

    private CharacterCardBuilder $characterCardBuilder;

    public function __construct(CharacterCardBuilder $characterCardBuilder)
    {
        parent::__construct(self::COMMAND_NAME);

        $this->characterCardBuilder = $characterCardBuilder;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach (\glob(self::CHARACTER_JSON_DIR . '*.json') as $filepath) {
            $data = $this->getDataFromFile($filepath);

            $this->validate($data);

            $this->createHtmlFile(CharacterFactory::createFromArray($data));
        }

        return Command::SUCCESS;
    }

    private function getDataFromFile(string $filepath): array
    {
        $data =  \file_get_contents($filepath);
        $data = \json_decode($data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // @todo changeme
            throw new \Exception('Invalid character data json.');
        }

        return $data;
    }

    private function validate(array $characterData): void
    {
        $characterDataValidator = new CharacterDataValidator();
        $characterDataValidator->addValidator(new PlayerNameValidator());
        $characterDataValidator->addValidator(new CharacterNameValidator());
        $characterDataValidator->addValidator(new RaceValidator());
        $characterDataValidator->addValidator(new AlignmentValidator());
        $characterDataValidator->addValidator(new StartingAbilitiesValidator());
        $characterDataValidator->addValidator(new LanguageValidator());

        $characterDataValidator->validate($characterData);
    }

    private function createHtmlFile(Character $character): void
    {
        $campaignName = CaseConverter::normalToSnake($character->getCampaignName());
        $outputDir = self::OUTPUT_DIR . $campaignName;

        if (false === \is_dir($outputDir)) {
            \mkdir($outputDir);
        }

        $filepath = \sprintf(
            '%s/%s_%s.html',
            $outputDir,
            \date('Y-m-d'),
            CaseConverter::normalToSnake($character->getCharacterName())
        );

        \file_put_contents($filepath, $this->characterCardBuilder->build($character));
    }
}
