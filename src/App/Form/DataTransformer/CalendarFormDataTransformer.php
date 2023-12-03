<?php

declare(strict_types=1);

namespace App\Form\DataTransformer;

use App\Form\CalendarForm;
use DND\Domain\User\User;
use DND\Domain\User\UserRepository;
use Symfony\Component\Form\DataTransformerInterface;

class CalendarFormDataTransformer implements DataTransformerInterface
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function transform(mixed $value): array
    {
        if (isset($value[CalendarForm::INVITE_USERS_FIELD])) {
            $value[CalendarForm::INVITE_USERS_FIELD] = $this->transformInviteUsers(
                $value[CalendarForm::INVITE_USERS_FIELD]
            );
        }

        return $value;
    }

    /**
     * @return User[]
     */
    public function reverseTransform(mixed $value): array
    {
        $value[CalendarForm::INVITE_USERS_FIELD] = $this->reverseTransformInviteUsers(
            $value[CalendarForm::INVITE_USERS_FIELD]
        );
        $value[CalendarForm::WILL_ATTEND_FIELD] = \json_decode(
            $value[CalendarForm::WILL_ATTEND_FIELD],
            true
        );
        $value[CalendarForm::MAYBE_ATTEND_FIELD] = \json_decode(
            $value[CalendarForm::MAYBE_ATTEND_FIELD],
            true
        );

//        $value[CalendarForm::IS_PUBLIC_FIELD] = isset($value[CalendarForm::IS_PUBLIC_FIELD]);

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
}
