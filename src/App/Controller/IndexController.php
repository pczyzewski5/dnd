<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\QueryBus\QueryBus;
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

    public function test(): Response
    {
        return $this->render('index/index.html.twig');
    }
}
