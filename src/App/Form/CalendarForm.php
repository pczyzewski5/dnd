<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\DataTransformer\InvitedUsersTransformer;
use App\FormType\CheckboxSwitchType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CalendarForm extends AbstractType
{
    public const TITLE_FIELD = 'title';
    public const IS_PUBLIC_FIELD = 'is_public';
    public const INVITE_USERS_FIELD = 'invite_users';
    public const WILL_ATTEND_FIELD = 'will_attend';
    public const MAYBE_ATTEND_FIELD = 'maybe_attend';
    public const OWNER_ID_FIELD = 'owner_id';

    private InvitedUsersTransformer $invitedUserTransformer;

    public function __construct(InvitedUsersTransformer $invitedUserTransformer)
    {
        $this->invitedUserTransformer = $invitedUserTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            self::TITLE_FIELD,
            TextType::class,
            ['required' => true, 'attr' => ['class' => 'input']],
        );

        $builder->add(
            self::IS_PUBLIC_FIELD,
            CheckboxSwitchType::class,
            ['required' => false, 'label' => 'Dostępny z zewnątrz?']
        );

        $builder->add(
            self::INVITE_USERS_FIELD,
            CollectionType::class,
            ['required' => false, 'entry_type' => CheckboxSwitchType::class]
        );
        $builder->get(self::INVITE_USERS_FIELD)->addModelTransformer(
            $this->invitedUserTransformer
        );

        $builder->add(
            self::WILL_ATTEND_FIELD,
            HiddenType::class,
            ['required' => true]
        );

        $builder->add(
            self::MAYBE_ATTEND_FIELD,
            HiddenType::class,
            ['required' => true]
        );

        $builder->add(
            self::OWNER_ID_FIELD,
            HiddenType::class,
            ['required' => true]
        );

        $builder->add(
            'zapisz',
            SubmitType::class,
            ['attr' => ['class' => 'button is-primary is-fullwidth']]
        );
    }
}
