<?php

namespace App\Form\Type;

use App\Command\UploadFile;
use App\Command\UploadFileHandler;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadImageType extends AbstractType
{
    private const MAX_FILE_SIZE = 1024;
    private const SUPPORTED_MIME = 'image/jpeg';

    public function __construct(
        private readonly UploadFileHandler $uploadFileHandler,
    ) {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'mapped' => false,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            [$this, 'onPreSubmit']
        );
    }

    public function onPreSubmit(PreSubmitEvent $event): void
    {
        $uploadedFile = $event->getData();
        $form = $event->getForm();

        $event->setData(null);

        if (!$uploadedFile instanceof UploadedFile) {
            $form->addError(
                new FormError('Plik jest wymagany.')
            );

            return;
        }

        if ($uploadedFile->getMimeType() !== self::SUPPORTED_MIME) {
            $form->addError(
                new FormError('Tylko pliki jpg są obsługiwane.')
            );

            return;
        }

        if ($uploadedFile->getSize() > self::MAX_FILE_SIZE * 1000) {
            $form->addError(
                new FormError('Rozmiar pliku nie może przekraczać 1024 kB.')
            );

            return;
        }

        $event->setData(
            $this->uploadFileHandler->handle(
                new UploadFile($uploadedFile)
            )
        );
    }

    public function getParent(): string
    {
        return FileType::class;
    }
}