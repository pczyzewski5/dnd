<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\DataTransformer\CreateCalendarFormDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateCalendarForm extends AbstractType
{
    public const TITLE_FIELD = 'title';
    public const DATES_FIELD = 'dates';
    public const USERS_FIELD = 'users';
    public const USER_PREFIX = 'user_';

    private CreateCalendarFormDataTransformer $dataTransformer;

    public function __construct(CreateCalendarFormDataTransformer $dataTransformer)
    {
        $this->dataTransformer = $dataTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer($this->dataTransformer);
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $usersChosen = 0;

            foreach ($event->getData() as $key => $bool) {
                if (\str_contains($key, self::USER_PREFIX) && $bool) {
                    $usersChosen++;
                }
            }

            if (0 === $usersChosen) {
                $event->getForm()->addError(
                    new FormError('Przed wyruszeniem w drogę należy zebrać drużynę!')
                );
            }
        });

        foreach ($builder->getData()['users'] as $user) {
            $builder->add(
                self::USER_PREFIX . $user->getId(),
                CheckboxType::class,
                [
                    'value' => $user->getId(),
                    'required' => false,
                    'label' => $user->getUsername(),
                    'attr' => ['is_user_checkbox' => true]
                ]
            );
        }

        $builder->add(
            self::TITLE_FIELD,
            TextType::class,
            [
                'required' => false,
                'attr' => ['class' => 'input'],
                'constraints' => new NotBlank(null, 'Tytuł nie może być pusty.')
            ]
        );

        $builder->add(
            self::DATES_FIELD,
            TextType::class,
            [
                'required' => false,
                'attr' => ['style' => 'display: none'],
                'constraints' => new NotBlank(null, 'Wybierz przynajmniej jeden dzień w kalendarzu.'),
            ]
        );

        $builder->add(
            'zapisz',
            SubmitType::class,
            ['attr' => ['class' => 'button is-primary is-fullwidth']]
        );
    }
}
