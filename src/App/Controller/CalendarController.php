<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\Form\CalendarForm;
use App\QueryBus\QueryBus;
use DND\Domain\Query\GetUsers;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends BaseController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function index(Request $request): Response
    {
        $startDate = new \DateTime('first day of this month');
        $finishDate = new \DateTime('last day of next month');
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($startDate, $interval, $finishDate, \DatePeriod::INCLUDE_END_DATE);

        $calendar = [];
        foreach ($period as $dateTime) {
            $calendar
            [$dateTime->format('Y')]
            [$dateTime->format('M')]
            [$dateTime->format('W')]
            [$dateTime->format('D')]
                = $dateTime;
        }

        $form = $this->createForm(CalendarForm::class, [
            CalendarForm::INVITE_USERS_FIELD => $this->queryBus->handle(new GetUsers()),
            CalendarForm::OWNER_ID_FIELD => $this->getUser()->getId()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            echo '<pre>';
            \var_dump($form->getData());
            echo '</pre>';
            exit;
        }

        return $this->renderForm('calendar/index.html.twig', [
            'calendar' => $calendar,
            'form' => $form
        ]);
    }
}
