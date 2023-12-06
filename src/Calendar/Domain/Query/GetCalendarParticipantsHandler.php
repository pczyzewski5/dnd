<?php

declare(strict_types=1);

namespace Calendar\Domain\Query;

use Calendar\Domain\CalendarParticipant\CalendarParticipantRepository;
use DND\Domain\User\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GetCalendarParticipantsHandler
{
    private CalendarParticipantRepository $repository;
    private User $user;

    public function __construct(
        CalendarParticipantRepository $repository,
        TokenStorageInterface $tokenStorage
    ) {
        $this->repository = $repository;
        $this->user = $tokenStorage->getToken()->getUser();
    }

    public function __invoke(GetCalendarParticipants $query): array
    {
        $participants = $this->repository->findByCalendarId(
            $query->getCalendar()->getId()
        );

        \usort($participants, function (array $participant) {
            return $participant['username'] === $this->user->getUsername()
                ? -1
                : 1;
        });

        return $participants;
    }
}
