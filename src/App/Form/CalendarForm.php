<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class CalendarForm extends AbstractType
{
    public const WILL_ATTEND_FIELD = 'will_attend';
    public const MAYBE_ATTEND_FIELD = 'maybe_attend';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
            'zapisz',
            SubmitType::class,
            ['attr' => ['class' => 'button is-primary is-fullwidth']]
        );
    }
}
