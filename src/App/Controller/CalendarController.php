<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\Form\CalendarForm;
use App\Form\CreateCalendarForm;
use App\QueryBus\QueryBus;
use Calendar\Domain\Command\CreateCalendar;
use Calendar\Domain\Command\CreateCalendarParticipants;
use Calendar\Domain\Command\GetDatesForCalendar;
use Calendar\Domain\Query\GetCalendarsForUser;
use DND\Domain\Query\GetUsers;
use DND\Domain\User\User;
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

    public function create(Request $request): Response
    {
        /** @var User $loggedInUser */
        $loggedInUser = $this->getUser();
        $users = $this->queryBus->handle(
            new GetUsers($loggedInUser)
        );

        $form = $this->createForm(CreateCalendarForm::class, [
            CreateCalendarForm::INVITE_USERS_FIELD => $users,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $participants = $data[CreateCalendarForm::INVITE_USERS_FIELD];
            $participants[] = $loggedInUser;

            $calendarId = $this->commandBus->handle(
                new CreateCalendar(
                    $data[CreateCalendarForm::TITLE_FIELD],
                    false, // $data[CreateCalendarForm::IS_PUBLIC_FIELD],
                    $loggedInUser->getId(),
                    $data[CreateCalendarForm::DATES_FIELD],
                )
            );

            $this->commandBus->handle(
                new CreateCalendarParticipants(
                    $calendarId,
                    $participants
                )
            );

            return $this->redirectToRoute('calendar_list');
        }

        $datesForCalendar = $this->commandBus->handle(
            new GetDatesForCalendar()
        );

        return $this->renderForm('calendar/create.html.twig', [
            'datesForCalendar' => $datesForCalendar,
            'form' => $form
        ]);
    }

    public function list(): Response
    {
        $calendars = $this->queryBus->handle(
            new GetCalendarsForUser($this->getUser())
        );

        return $this->renderForm('calendar/list.html.twig', [
            'calendars' => $calendars
        ]);
    }
}
