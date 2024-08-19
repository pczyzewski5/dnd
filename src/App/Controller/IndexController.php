<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\QueryBus\QueryBus;
use nadar\quill\Lexer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', 'home', methods: [Request::METHOD_GET])]
    public function index(): Response
    {
        return $this->render('index/index.html.twig');
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
