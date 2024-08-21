<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class UcWords extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('ucWords', [$this, 'makeUcWords'])
        ];
    }

    public function makeUcWords(string $string): string
    {
        return \ucwords($string);
    }
}
