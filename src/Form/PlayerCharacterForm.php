<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\PlayerCharacter\Entity\PlayerCharacter;

class PlayerCharacterForm extends AbstractType
{
    public const DATA = 'data';
    public const OWNER_ID = 'owner_id';

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PlayerCharacter::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            self::DATA,
            TextType::class,
            [
                'label' => 'json',
                'attr' => ['class' => 'input'],
                'required' => true
            ]
        );

        $builder->add(
            self::OWNER_ID,
            HiddenType::class,
            [
                'label' => 'owner',
                'data' => '52efbfbd-262c-efbf-bdef-bfbd11efbfbd',
                'attr' => ['class' => 'input'],
                'required' => true
            ]
        );

        $builder->add(
            'submit',
            SubmitType::class,
            [
                'attr' => ['class' => 'button is-primary is-fullwidth']
            ]
        );
    }
}
