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
        if (isset($value[CreateCalendarForm::INVITE_USERS_FIELD])) {
            $value[CreateCalendarForm::INVITE_USERS_FIELD] = $this->transformInviteUsers(
                $value[CreateCalendarForm::INVITE_USERS_FIELD]
            );
        }

        return $value;
    }

    /**
     * @return User[]
     */
    public function reverseTransform(mixed $value): array
    {
        $value[CreateCalendarForm::INVITE_USERS_FIELD] = $this->reverseTransformInviteUsers(
            $value[CreateCalendarForm::INVITE_USERS_FIELD]
        );

        $value[CreateCalendarForm::DATES_FIELD] = $this->reverseTransformDates(
            $value[CreateCalendarForm::DATES_FIELD]
        );

//        $value[CreateCalendarForm::IS_PUBLIC_FIELD] = isset($value[CreateCalendarForm::IS_PUBLIC_FIELD]);

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

    private function reverseTransformInviteUsers(array $invitedUsers): array
    {
        $userIds = \array_filter($invitedUsers);

        return empty($userIds)
            ? []
            : $this->repository->getManyById($userIds);
    }

    private function reverseTransformDates(string $dates): array
    {
        $result = [];

        foreach (\json_decode($dates, true) as $date) {
            $result[] = \DateTimeImmutable::createFromFormat('Y-m-d', $date);
        }

        return $result;
    }
}
