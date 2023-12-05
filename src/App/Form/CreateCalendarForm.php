<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\DataTransformer\CalendarFormDataTransformer;
use App\Form\DataTransformer\CreateCalendarFormDataTransformer;
use App\FormType\CheckboxSwitchType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateCalendarForm extends AbstractType
{
    public const TITLE_FIELD = 'title';
    public const IS_PUBLIC_FIELD = 'is_public';
    public const INVITE_USERS_FIELD = 'invite_users';
    public const DATES_FIELD = 'dates';

    private CreateCalendarFormDataTransformer $dataTransformer;

    public function __construct(CreateCalendarFormDataTransformer $dataTransformer)
    {
        $this->dataTransformer = $dataTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer($this->dataTransformer);

        $builder->add(
            self::TITLE_FIELD,
            TextType::class,
            ['required' => true, 'attr' => ['class' => 'input']],
        );

//        $builder->add(
//            self::IS_PUBLIC_FIELD,
//            CheckboxSwitchType::class,
//            ['required' => false, 'label' => 'Dostępny z zewnątrz?']
//        );

        $builder->add(
            self::INVITE_USERS_FIELD,
            CollectionType::class,
            ['required' => false, 'entry_type' => CheckboxSwitchType::class]
        );

        $builder->add(
            self::DATES_FIELD,
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
