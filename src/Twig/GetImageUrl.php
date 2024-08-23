<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

use function var_dump;

class GetImageUrl extends AbstractExtension
{
    public function __construct(private readonly string $itemCardImagesDirectory)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getImageUrl', [$this, 'getImageUrl'])
        ];
    }

    public function getImageUrl(string $filename): string
    {
        return \preg_replace(
            '/^.+(?=\/images)/i',
            '',
            $this->itemCardImagesDirectory . '/' . $filename
        );
    }
}
