<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\DataTransformer\CalendarFormDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CalendarAnswerForm extends AbstractType
{
    public const WILL_ATTEND_FIELD = 'will_attend';
    public const MAYBE_ATTEND_FIELD = 'maybe_attend';

    private CalendarFormDataTransformer $calendarFormDataTransformer;

    public function __construct(CalendarFormDataTransformer $calendarFormDataTransformer)
    {
        $this->calendarFormDataTransformer = $calendarFormDataTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer($this->calendarFormDataTransformer);

        $builder->add(
            self::WILL_ATTEND_FIELD,
            TextType::class,
            ['required' => true]
        );

        $builder->add(
            self::MAYBE_ATTEND_FIELD,
            TextType::class,
            ['required' => true]
        );

        $builder->add(
            'zapisz',
            SubmitType::class,
            ['attr' => ['class' => 'button is-primary is-fullwidth']]
        );
    }
}
