<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\Form\CalendarForm;
use App\QueryBus\QueryBus;
use Calendar\Domain\Command\CreateCalendar;
use Calendar\Domain\Command\CreateCalendarParticipants;
use Calendar\Domain\Command\GetDatesForCalendar;
use Calendar\Domain\Command\UpdateCalendarParticipantResponse;
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

        $form = $this->createForm(CalendarForm::class, [
            CalendarForm::INVITE_USERS_FIELD => $users,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $participants = $data[CalendarForm::INVITE_USERS_FIELD];
            $participants[] = $loggedInUser;

            $calendarId = $this->commandBus->handle(
                new CreateCalendar(
                    $data[CalendarForm::TITLE_FIELD],
                    $data[CalendarForm::IS_PUBLIC_FIELD],
                    $loggedInUser->getId()
                )
            );

            $this->commandBus->handle(
                new CreateCalendarParticipants(
                    $calendarId,
                    $participants
                )
            );

            $this->commandBus->handle(
                new UpdateCalendarParticipantResponse(
                    $calendarId,
                    $loggedInUser->getId(),
                    $data[CalendarForm::WILL_ATTEND_FIELD],
                    $data[CalendarForm::MAYBE_ATTEND_FIELD],
                )
            );

            return $this->redirectToRoute('calendar_list');
        }

        $datesForCalendar = $this->commandBus->handle(
            new GetDatesForCalendar()
        );

        return $this->renderForm('calendar/index.html.twig', [
            'datesForCalendar' => $datesForCalendar,
            'form' => $form
        ]);
    }

    public function list(): Response
    {
        return $this->renderForm('calendar/list.html.twig');
    }
}
