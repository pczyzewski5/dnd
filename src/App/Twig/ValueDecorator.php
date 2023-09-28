<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ValueDecorator extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('value', [$this, 'decorate'])
        ];
    }

    public function decorate(int $value): string
    {
        $prefix = '';
        if ($value >= 0) {
            $prefix = '+';
        }

        return $prefix . $value;
    }
}
