<?php

namespace App\Dto\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
class AbilityConfigs extends Constraint
{
}
