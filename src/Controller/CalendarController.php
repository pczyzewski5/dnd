<?php

declare(strict_types=1);

namespace App\Controller;

use App\Calendar\Application\Command\CreateCalendar;
use App\Calendar\Application\Command\CreateCalendarParticipants;
use App\Calendar\Application\Command\DeleteCalendar;
use App\Calendar\Application\Command\GetDatesForCalendar;
use App\Calendar\Application\Command\UpdateCalendarParticipantResponse;
use App\Calendar\Application\Handler\CreateCalendarHandler;
use App\Calendar\Application\Handler\CreateCalendarParticipantsHandler;
use App\Calendar\Application\Handler\DeleteCalendarHandler;
use App\Calendar\Application\Handler\GetCalendarHelperHandler;
use App\Calendar\Application\Handler\GetCalendarsForUserHandler;
use App\Calendar\Application\Handler\GetDatesForCalendarHandler;
use App\Calendar\Application\Handler\UpdateCalendarParticipantResponseHandler;
use App\Calendar\Application\Query\GetCalendarHelper;
use App\Calendar\Application\Query\GetCalendarsForUser;
use App\Entity\User;
use App\Form\CalendarAnswerForm;
use App\Form\CreateCalendarForm;
use App\User\Handler\GetUsersHandler;
use App\User\Query\GetUsers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class CalendarController extends AbstractController
{
    public function __construct(
        private readonly GetCalendarHelperHandler $getCalendarHelperHandler,
        private readonly UpdateCalendarParticipantResponseHandler $updateCalendarParticipantResponseHandler,
        private readonly GetDatesForCalendarHandler $getDatesForCalendarHandler,
        private readonly GetCalendarsForUserHandler $getCalendarsForUserHandler,
        private readonly DeleteCalendarHandler $deleteCalendarHandler,
    )
    {
    }

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
        $calendarId = Uuid::fromString($request->get('id'));
        $calendarHelper = $this->getCalendarHelperHandler->__invoke(
            new GetCalendarHelper($calendarId)
        );

        $form = $this->createForm(CalendarAnswerForm::class, [
            CalendarAnswerForm::CALENDAR_PARTICIPANTS => $calendarHelper->getParticipants()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updateCalendarParticipantResponseHandler->handle(
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

        $datesForCalendar = $this->getDatesForCalendarHandler->handle(
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
            'calendars' => $this->getCalendarsForUserHandler->handle(
                new GetCalendarsForUser($this->getUser())
            )
        ]);
    }

    public function delete(Request $request): Response
    {
        $this->deleteCalendarHandler->handle(
            new DeleteCalendar(
                $request->get('id')
            )
        );

        return $this->redirectToRoute('calendar_list');
    }
}
