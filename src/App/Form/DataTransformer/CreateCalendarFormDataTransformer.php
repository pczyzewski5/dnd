<?php

declare(strict_types=1);

namespace App\Form\DataTransformer;

use App\Form\CreateCalendarForm;
use DND\Domain\User\User;
use DND\Domain\User\UserRepository;
use Symfony\Component\Form\DataTransformerInterface;

class CreateCalendarFormDataTransformer implements DataTransformerInterface
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function transform(mixed $value): array
    {
        return $value;
    }

    public function reverseTransform(mixed $value): array
    {
        if (isset($value[CreateCalendarForm::DATES_FIELD])) {
            $value[CreateCalendarForm::DATES_FIELD] = $this->reverseTransformDates(
                $value[CreateCalendarForm::DATES_FIELD]
            );
        }
        $value[CreateCalendarForm::USERS_FIELD] = $this->reverseTransformUsers(
            $value[CreateCalendarForm::USERS_FIELD],
            $value
        );

        return $value;
    }

    private function transformInviteUsers(array $invitedUsers): array
    {
        $result = [];

        /** @var User $user */
        foreach ($invitedUsers as $user) {
            $result[] = [
                'value' => $user->getId(),
                'description' => $user->getUsername()
            ];
        }

        return $result;
    }

    private function reverseTransformDates(string $dates): array
    {
        $result = [];

        foreach (\json_decode($dates, true) as $date) {
            $result[] = \DateTimeImmutable::createFromFormat('Y-m-d', $date);
        }

        return $result;
    }

    private function reverseTransformUsers(array $providedUsers, array $submittedData): array
    {
        $result = [];
        $invitedUserIds = [];

        foreach ($submittedData as $key => $bool) {
            if (\str_contains($key, CreateCalendarForm::USER_PREFIX) && $bool) {
                $invitedUserIds[] = \str_replace(CreateCalendarForm::USER_PREFIX, '', $key);
            }
        }

        /** @var User $user */
        foreach ($providedUsers as $user) {
            if (\in_array($user->getId(), $invitedUserIds)) {
                $result[] = $user;
            }
        }

        return $result;
    }
}
