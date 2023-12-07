<?php

declare(strict_types=1);

namespace App\Form\DataTransformer;

use App\Form\CalendarAnswerForm;
use DND\Domain\User\User;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AnswerCalendarFormDataTransformer implements DataTransformerInterface
{
    private string $loggedUserId;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->loggedUserId = $tokenStorage->getToken()->getUser()->getId();
    }

    public function transform(mixed $value): ?array
    {
        foreach ($value[CalendarAnswerForm::CALENDAR_PARTICIPANTS] as $participant) {
           if ($participant['id'] === $this->loggedUserId) {
               if (null !== $participant['will_attend']) {
                   $value[CalendarAnswerForm::WILL_ATTEND_FIELD] = \json_encode($participant['will_attend']);
               }
               if (null !== $participant['maybe_attend']) {
                   $value[CalendarAnswerForm::MAYBE_ATTEND_FIELD] = \json_encode($participant['maybe_attend']);
               }
               if (null !== $participant['wont_attend']) {
                   $value[CalendarAnswerForm::WONT_ATTEND_FIELD] = \json_encode($participant['wont_attend']);
               }
              break;
           }
        }

        return $value;
    }

    /**
     * @return User[]
     */
    public function reverseTransform(mixed $value): array
    {
        if (null !== $value[CalendarAnswerForm::WILL_ATTEND_FIELD]) {
            $value[CalendarAnswerForm::WILL_ATTEND_FIELD] = \json_decode(
                $value[CalendarAnswerForm::WILL_ATTEND_FIELD],
                true
            );
        }
        if (null !== $value[CalendarAnswerForm::MAYBE_ATTEND_FIELD]) {
            $value[CalendarAnswerForm::MAYBE_ATTEND_FIELD] = \json_decode(
                $value[CalendarAnswerForm::MAYBE_ATTEND_FIELD],
                true
            );
        }
        if (null !== $value[CalendarAnswerForm::WONT_ATTEND_FIELD]) {
            $value[CalendarAnswerForm::WONT_ATTEND_FIELD] = \json_decode(
                $value[CalendarAnswerForm::WONT_ATTEND_FIELD],
                true
            );
        }

        return $value;
    }
}
