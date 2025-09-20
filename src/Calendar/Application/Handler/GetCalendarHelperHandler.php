<?php

declare(strict_types=1);

namespace App\Calendar\Application\Handler;

use App\Calendar\Application\Query\GetCalendarHelper;
use App\Calendar\Domain\Service\CalendarService;
use App\Calendar\Infrastructure\Persistance\Repository\CalendarParticipantRepository;
use App\Calendar\Infrastructure\Persistance\Repository\CalendarRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Uid\Uuid;

class GetCalendarHelperHandler
{
    private CalendarRepository $calendarRepository;
    private CalendarParticipantRepository $calendarParticipantRepository;
    private Uuid $loggerInUserId;

    public function __construct(
        CalendarRepository $calendarRepository,
        CalendarParticipantRepository $calendarParticipantRepository,
        TokenStorageInterface $tokenStorage
    ) {
        $this->calendarRepository = $calendarRepository;
        $this->calendarParticipantRepository = $calendarParticipantRepository;
        $this->loggerInUserId = $tokenStorage->getToken()->getUser()->getId();
    }


    public function __invoke(GetCalendarHelper $query): CalendarService
    {
        return new CalendarService(
            $this->calendarRepository->getOneById($query->getCalendarId()),
            $this->getCalendarParticipants($query->getCalendarId())
        );
    }

    private function getCalendarParticipants(Uuid $calendarId): array
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
