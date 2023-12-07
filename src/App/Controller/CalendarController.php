<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\Form\CalendarAnswerForm;
use App\Form\CreateCalendarForm;
use App\QueryBus\QueryBus;
use Calendar\Domain\CalendarHelper;
use Calendar\Domain\Command\CreateCalendar;
use Calendar\Domain\Command\CreateCalendarParticipants;
use Calendar\Domain\Command\DeleteCalendar;
use Calendar\Domain\Command\GetDatesForCalendar;
use Calendar\Domain\Command\UpdateCalendarParticipantResponse;
use Calendar\Domain\Query\GetCalendarHelper;
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

            return $this->redirectToRoute('calendar_answer', ['id' => $calendarId]);
        }

        $datesForCalendar = $this->commandBus->handle(
            new GetDatesForCalendar()
        );

        return $this->renderForm('calendar/create.html.twig', [
            'datesForCalendar' => $datesForCalendar,
            'form' => $form
        ]);
    }

    public function answer(Request $request): Response
    {
        $calendarId = $request->get('id');
        /** @var CalendarHelper $calendarHelper */
        $calendarHelper = $this->queryBus->handle(
            new GetCalendarHelper($calendarId)
        );

        $form = $this->createForm(CalendarAnswerForm::class, [
            CalendarAnswerForm::CALENDAR_PARTICIPANTS => $calendarHelper->getParticipants()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle(
              new UpdateCalendarParticipantResponse(
                  $calendarId,
                  $this->getUser()->getId(),
                  $form->getData()[CalendarAnswerForm::WILL_ATTEND_FIELD],
                  $form->getData()[CalendarAnswerForm::MAYBE_ATTEND_FIELD],
              )
            );

            return $this->redirectToRoute('calendar_answer', ['id' => $calendarId]);
        }

        $datesForCalendar = $this->commandBus->handle(
            new GetDatesForCalendar(
                $calendarHelper->getCalendar()
            )
        );

        return $this->renderForm('calendar/answer.html.twig', [
            'datesForCalendar' => $datesForCalendar,
            'calendarHelper' => $calendarHelper,
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

    public function delete(Request $request): Response
    {
        $this->commandBus->handle(
            new DeleteCalendar(
                $request->get('id')
            )
        );

        return $this->redirectToRoute('calendar_list');
    }
}
