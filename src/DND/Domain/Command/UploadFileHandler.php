<?php

declare(strict_types=1);

namespace DND\Domain\Command;

use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadFileHandler
{
    private SluggerInterface $slugger;
    private array $cardImagesAllowedMime;
    private string $cardImagesDirectory;

    public function __construct(
        SluggerInterface $slugger,
        array $cardImagesAllowedMime,
        string $cardImagesDirectory
    ) {
        $this->slugger = $slugger;
        $this->cardImagesAllowedMime = $cardImagesAllowedMime;
        $this->cardImagesDirectory = $cardImagesDirectory;
    }

    public function handle(UploadFile $command): string
    {
        $uploadedFile = $command->getUploadedFile();

        if (false === \in_array($uploadedFile->getMimeType(), $this->cardImagesAllowedMime)) {
            $message = \sprintf(
                'Invalid mime type: %s, allowed are: %s.',
                $uploadedFile->getMimeType(),
                \implode(', ', $this->cardImagesAllowedMime)
            );
            throw new UploadException($message);
        }

        $newFilename = \sprintf(
            '%s-%s.%s',
            $this->slugger->slug($uploadedFile->getFilename()),
            uniqid(),
            $uploadedFile->guessExtension()
        );
        $uploadedFile->move($this->cardImagesDirectory, $newFilename);

        return $newFilename;
    }
}
