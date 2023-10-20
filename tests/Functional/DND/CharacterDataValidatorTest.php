<?php

declare(strict_types=1);

namespace Tests\Functional\DND;

use DND\CharacterDataValidator;
use DND\Validators\AlignmentValidator;
use DND\Validators\CharacterNameValidator;
use DND\Validators\LanguageValidator;
use DND\Validators\PlayerNameValidator;
use DND\Validators\RaceValidator;
use DND\Validators\StartingAbilitiesValidator;
use PHPUnit\Framework\TestCase;

class CharacterDataValidatorTest extends TestCase
{
    private array $characterData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->characterData = \json_decode(
            \file_get_contents('sydda.json'),
            true
        );
    }

    /**
     * @test
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
