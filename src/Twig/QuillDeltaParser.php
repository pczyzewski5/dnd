<?php

declare(strict_types=1);

namespace App\Twig;

use nadar\quill\Lexer;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFilter;

class QuillDeltaParser extends AbstractExtension
{
    public function __construct(private readonly Environment $twigEnv)
    {
    }

    public function getFilters()
    {
        return [
            new TwigFilter('quill', [$this, 'parseQuillDelta'])
        ];
    }

    public function parseQuillDelta(string $quillDelta, bool $stripTags = false): Markup
    {
        $lexer = new Lexer($quillDelta);
        $data = $lexer->render();

        if ($stripTags) {
            $data = \strip_tags($data);
        }

        return new Markup($data, $this->twigEnv->getCharset());
    }
}
