<?php

declare(strict_types=1);

namespace App\Tests\DND\Domain\Functional\Validator;

use DND\Domain\Validator\CharacterDataValidator;
use DND\Domain\Validator\Validators\AlignmentValidator;
use DND\Domain\Validator\Validators\CharacterNameValidator;
use DND\Domain\Validator\Validators\LanguageValidator;
use DND\Domain\Validator\Validators\PlayerNameValidator;
use DND\Domain\Validator\Validators\RaceValidator;
use DND\Domain\Validator\Validators\StartingAbilitiesValidator;
use PHPUnit\Framework\TestCase;

class CharacterDataValidatorTest extends TestCase
{
    private array $characterData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->characterData = \json_decode(
            \file_get_contents(__DIR__ . '/data/sydda.json'),
            true
        );
    }

    /**
     * @test
     * @todo changeme
     */
    public function underDev()
    {
        $playerNameValidator = new PlayerNameValidator();
        $characterNameValidator = new CharacterNameValidator();
        $raceValidator = new RaceValidator();
        $alignmentValidator = new AlignmentValidator();
        $originValidator = new AlignmentValidator();
        $startingStatsValidator = new StartingAbilitiesValidator();

        $characterDataValidator = new CharacterDataValidator();
        $characterDataValidator->addValidator($playerNameValidator);
        $characterDataValidator->addValidator($characterNameValidator);
        $characterDataValidator->addValidator($raceValidator);
        $characterDataValidator->addValidator($alignmentValidator);
        $characterDataValidator->addValidator($startingStatsValidator);
        $characterDataValidator->addValidator($originValidator);
//        $characterDataValidator->addValidator(new ProficiencyValidator());
        $characterDataValidator->addValidator(new LanguageValidator());

        $characterDataValidator->validate($this->characterData);
    }
}
