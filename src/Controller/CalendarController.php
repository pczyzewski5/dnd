<?php

declare(strict_types=1);

namespace App\Controller;

use App\Calendar\CalendarHelper;
use App\Calendar\Command\CreateCalendar;
use App\Calendar\Command\CreateCalendarHandler;
use App\Calendar\Command\CreateCalendarParticipants;
use App\Calendar\Command\CreateCalendarParticipantsHandler;
use App\Calendar\Command\DeleteCalendar;
use App\Calendar\Command\GetDatesForCalendar;
use App\Calendar\Command\GetDatesForCalendarHandler;
use App\Calendar\Command\UpdateCalendarParticipantResponse;
use App\Calendar\Query\GetCalendarHelper;
use App\Calendar\Query\GetCalendarsForUser;
use App\Calendar\Query\GetCalendarsForUserHandler;
use App\Form\CalendarAnswerForm;
use App\Form\CreateCalendarForm;
use App\User\Entity\User;
use App\User\Query\GetUsers;
use App\User\Query\GetUsersHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    #[Route('/calendar/create', 'calendar_create', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function create(
        Request $request,
        GetUsersHandler $getUsersHandler,
        CreateCalendarHandler $createCalendarHandler,
        CreateCalendarParticipantsHandler $createCalendarParticipantsHandler,
        GetDatesForCalendarHandler $getDatesForCalendarHandler
    ): Response {
        /** @var User $loggedInUser */
        $loggedInUser = $this->getUser();
        $users = $getUsersHandler->handle(
            new GetUsers($loggedInUser)
        );

        $form = $this->createForm(CreateCalendarForm::class, [
            CreateCalendarForm::USERS_FIELD => $users,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $participants = $data[CreateCalendarForm::USERS_FIELD];
            $participants[] = $loggedInUser;

            $calendarId = $createCalendarHandler->handle(
                new CreateCalendar(
                    $data[CreateCalendarForm::TITLE_FIELD],
                    $loggedInUser->getId(),
                    $data[CreateCalendarForm::DATES_FIELD],
                )
            );

            $createCalendarParticipantsHandler->handle(
                new CreateCalendarParticipants(
                    $calendarId,
                    $participants
                )
            );

            return $this->redirectToRoute('calendar_answer', ['id' => $calendarId]);
        }

        $datesForCalendar = $getDatesForCalendarHandler->handle(
            new GetDatesForCalendar()
        );

        return $this->render('calendar/create.html.twig', [
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
                    $form->getData()[CalendarAnswerForm::WONT_ATTEND_FIELD],
                )
            );

            return $this->redirectToRoute('calendar_answer', ['id' => $calendarId]);
        }

        $datesForCalendar = $this->commandBus->handle(
            new GetDatesForCalendar(
                $calendarHelper->getCalendar()
            )
        );

        return $this->render('calendar/answer.html.twig', [
            'datesForCalendar' => $datesForCalendar,
            'calendarHelper' => $calendarHelper,
            'form' => $form
        ]);
    }

    #[Route('/calendar/list', 'calendar_list', methods: [Request::METHOD_GET])]
    public function list(GetCalendarsForUserHandler $getCalendarsForUserHandler): Response
    {
        return $this->render('calendar/list.html.twig', [
            'calendars' => $getCalendarsForUserHandler->handle(
                new GetCalendarsForUser($this->getUser())
            )
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
