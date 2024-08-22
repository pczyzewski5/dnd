<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ItemCardImage extends AbstractExtension
{
    public function __construct(private readonly string $itemCardImagesDirectory)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('itemCardImage', [$this, 'getItemCardImage'])
        ];
    }

    public function getItemCardImage(string $filename): string
    {
        $filepath = $this->itemCardImagesDirectory . '/' . $filename;
        $filepath = \preg_replace('/^.+(?=\/images)/i', '', $filepath);

        return \sprintf(
            'style="background-image: url(%s); background-size: revert-layer;"',
            $filepath
        );
    }
}
