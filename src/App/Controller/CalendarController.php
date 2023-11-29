<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\Form\CalendarForm;
use App\QueryBus\QueryBus;
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

        $form = $this->createForm(CalendarForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            \var_dump(
                \json_decode(
                    $form->getData()[CalendarForm::WILL_ATTEND_FIELD],
                    true
                ),
                \json_decode(
                    $form->getData()[CalendarForm::MAYBE_ATTEND_FIELD],
                    true
                )
            );exit;
        }
        return $this->renderForm('calendar/index.html.twig', [
            'calendar' => $calendar,
            'form' => $form
        ]);
    }
}
