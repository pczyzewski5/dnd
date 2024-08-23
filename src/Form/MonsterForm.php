<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\Type\UploadImageType;
use App\Monster\Entity\Monster;
use App\Monster\Entity\MonsterFactory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MonsterForm extends AbstractType
{
    public const NAME = 'name';
    public const ARMOR_CLASS = 'armor_class';
    public const MAX_HP = 'max_hp';
    public const UPLOADED_IMAGE = 'uploaded_image';

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Monster::class,
            'empty_data' => static function (FormInterface $form): Monster {
                return MonsterFactory::create(
                    $form->get(self::NAME)->getData(),
                    $form->get(self::ARMOR_CLASS)->getData(),
                    $form->get(self::MAX_HP)->getData(),
                    $form->get(self::UPLOADED_IMAGE)->getData() ?? '',
                );
            },
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            self::NAME,
            TextType::class,
            [
                'label' => 'Nazwa',
                'attr' => ['class' => 'input'],
                'required' => true
            ]
        );

        $builder->add(
            self::ARMOR_CLASS,
            IntegerType::class,
            [
                'label' => 'Klasa pancerza',
                'attr' => ['class' => 'input'],
                'required' => true
            ]
        );

        $builder->add(
            self::MAX_HP,
            IntegerType::class,
            [
                'label' => 'Punkty wytrzymałości',
                'attr' => ['class' => 'input'],
                'required' => true
            ]
        );

        $builder->add(
            self::UPLOADED_IMAGE,
            UploadImageType::class,
            [
                'label' => 'Matryca',
                'required' => empty($builder->getData()),
                'attr' => ['class' => 'file-input'],
            ],
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
