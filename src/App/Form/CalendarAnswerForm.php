<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\DataTransformer\AnswerCalendarFormDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class CalendarAnswerForm extends AbstractType
{
    public const CALENDAR_PARTICIPANTS = 'calendar_participants';

    public const WILL_ATTEND_FIELD = 'will_attend';
    public const MAYBE_ATTEND_FIELD = 'maybe_attend';

    private AnswerCalendarFormDataTransformer $dataTransformer;

    public function __construct(AnswerCalendarFormDataTransformer $dataTransformer)
    {
        $this->dataTransformer = $dataTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer($this->dataTransformer);

        $builder->add(
            self::WILL_ATTEND_FIELD,
            HiddenType::class,
            ['required' => false]
        );

        $builder->add(
            self::MAYBE_ATTEND_FIELD,
            HiddenType::class,
            ['required' => false]
        );

        $builder->add(
            'zapisz',
            SubmitType::class,
            ['attr' => ['class' => 'button is-primary is-fullwidth']]
        );
    }
}
