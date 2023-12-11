<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ItemCardImage extends AbstractExtension
{
    private string $itemCardImagesDirectory;

    public function __construct(
        string $itemCardImagesDirectory
    ) {
        $this->itemCardImagesDirectory = $itemCardImagesDirectory;
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
