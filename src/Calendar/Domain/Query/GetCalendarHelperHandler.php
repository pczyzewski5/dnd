<?php

declare(strict_types=1);

namespace Calendar\Domain\Query;

use Calendar\Domain\Calendar\CalendarRepository;
use Calendar\Domain\CalendarHelper;
use Calendar\Domain\CalendarParticipant\CalendarParticipantRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GetCalendarHelperHandler
{
    private CalendarRepository $calendarRepository;
    private CalendarParticipantRepository $calendarParticipantRepository;
    private string $loggerInUserId;

    public function __construct(
        CalendarRepository $calendarRepository,
        CalendarParticipantRepository $calendarParticipantRepository,
        TokenStorageInterface $tokenStorage
    ) {
        $this->calendarRepository = $calendarRepository;
        $this->calendarParticipantRepository = $calendarParticipantRepository;
        $this->loggerInUserId = $tokenStorage->getToken()->getUser()->getId();
    }


    public function __invoke(GetCalendarHelper $query): CalendarHelper
    {
        return new CalendarHelper(
            $this->calendarRepository->getOneById($query->getCalendarId()),
            $this->getCalendarParticipants($query->getCalendarId())
        );
    }

    private function getCalendarParticipants(string $calendarId): array
    {
        $participants = $this->calendarParticipantRepository->findByCalendarId(
            $calendarId
        );

        \usort($participants, function (array $participant) {
            return $participant['id'] === $this->loggerInUserId
                ? -1
                : 1;
        });

        return $participants;
    }
}
