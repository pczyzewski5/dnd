<?php

declare(strict_types=1);

namespace App\Form;

use App\FormType\QuillType;
use DND\Domain\Enum\ItemCardCategoryEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class ItemCardForm extends AbstractType
{
    public const ITEM_CATEGORY_FIELD = 'item_category';
    public const ITEM_TITLE_FIELD = 'item_title';
    public const ITEM_DESCRIPTION_FIELD = 'item_description';
    public const ITEM_ORIGIN_FIELD = 'item_origin';
    public const ITEM_IMAGE_FIELD = 'item_image';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            self::ITEM_CATEGORY_FIELD,
            ChoiceType::class,
            [
                'label' => 'Rodzaj',
                'required' => true,
                'choices' => [
                    ItemCardCategoryEnum::ITEM => ItemCardCategoryEnum::ITEM,
                    ItemCardCategoryEnum::SPELL => ItemCardCategoryEnum::SPELL,
                ]
            ]
        );

        $builder->add(
            self::ITEM_TITLE_FIELD,
            TextType::class,
            [
                'label' => 'Nazwa',
                'attr' => ['class' => 'input'],
                'required' => true
            ]
        );

        $builder->add(
            self::ITEM_DESCRIPTION_FIELD,
            QuillType::class,
            [
                'label' => 'Opis',
                'attr' => ['class' => 'textarea'],
                'required' => true
            ]
        );

        $builder->add(
            self::ITEM_ORIGIN_FIELD,
            TextType::class,
            [
                'label' => 'Pochodzenie',
                'attr' => ['class' => 'input'],
                'required' => true
            ]
        );

        $builder->add(
            self::ITEM_IMAGE_FIELD,
            FileType::class,
            [
                'label' => 'Grafika',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => ['image/jpeg', 'image/x-png'],
                        'mimeTypesMessage' => 'Please upload jpg image.',
                    ])
                ],
                'attr' => ['class' => 'file-input']
            ],
        );

        $builder->add(
            'zapisz',
            SubmitType::class,
            [
                'attr' => ['class' => 'button is-primary is-fullwidth']
            ]
        );
    }
}
