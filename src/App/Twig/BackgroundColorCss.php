<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BackgroundColorCss extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('backgroundColor', [$this, 'generateCssRule'])
        ];
    }

    public function generateCssRule(): string
    {
        return \sprintf(
          'background-color: rgba(%s, %s, %s, 0.3);',
            \rand(0,255),
            \rand(0,255),
            \rand(0,255)
        );
    }
}
