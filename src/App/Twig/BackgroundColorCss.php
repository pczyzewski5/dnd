<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BackgroundColorCss extends AbstractExtension
{
    private bool $devMode = false;

    public function __construct(bool $devMode)
    {
        $this->devMode = $devMode;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('backgroundColor', [$this, 'generateCssRule'])
        ];
    }

    public function generateCssRule(): string
    {
        $opacity = 0;
        if ($this->devMode) {
            $opacity = 0.3;
        }

        return \sprintf(
            'background-color: rgba(%s, %s, %s, %s);',
            \rand(0,255),
            \rand(0,255),
            \rand(0,255),
            $opacity
        );
    }
}
