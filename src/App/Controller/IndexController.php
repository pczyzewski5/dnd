<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\QueryBus\QueryBus;
use nadar\quill\Lexer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends BaseController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function index(): Response
    {
        return $this->renderForm('index/index.html.twig');
    }

    public function quill(Request $request): Response
    {
        $content = $request->getContent();

        empty($content)
            ? $body = ''
            : $body = (new Lexer($content))->render();

        return new Response($body);
    }
}
