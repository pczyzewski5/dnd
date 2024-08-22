<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFilter;

class ProficiencyDot extends AbstractExtension
{
    public function __construct(private readonly Environment $twigEnv)
    {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('dot', [$this, 'putProficiencyDot'])
        ];
    }

    public function putProficiencyDot(bool $hasProficiency): Markup
    {
        $cssClass = 'empty-dot';
        if ($hasProficiency) {
            $cssClass = 'black-dot';
        }

        return new Markup(
            '<span class="' . $cssClass . '"/>',
            $this->twigEnv->getCharset()
        );
    }
}
