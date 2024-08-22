<?php

declare(strict_types=1);

namespace App\Command;

use App\CaseConverter;
use App\Character\Character;
use App\PlayerCharacter\Entity\PlayerCharacter;
use App\PlayerCharacter\Entity\PlayerCharacterFactory;
use App\CharacterCard\CharacterCardBuilder;
use App\Validator\CharacterDataValidator;
use App\Validator\Validators\AlignmentValidator;
use App\Validator\Validators\CharacterNameValidator;
use App\Validator\Validators\LanguageValidator;
use App\Validator\Validators\PlayerNameValidator;
use App\Validator\Validators\RaceValidator;
use App\Validator\Validators\StartingAbilitiesValidator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'dnd:create-character-card')]
class CreateCharacterCardCommand extends Command
{
    private const CHARACTER_JSON_DIR = 'input/';
    private const OUTPUT_DIR = 'output/';

    private CharacterCardBuilder $characterCardBuilder;

    public function __construct(CharacterCardBuilder $characterCardBuilder)
    {
        $this->characterCardBuilder = $characterCardBuilder;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach (\glob(self::CHARACTER_JSON_DIR . '*.json') as $filepath) {
            $data = $this->getDataFromFile($filepath);

            $this->validate($data);

            $this->createHtmlFile(PlayerCharacterFactory::createFromArray($data));
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
