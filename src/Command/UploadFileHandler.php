<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadFileHandler
{
    public function __construct(
        private readonly SluggerInterface $slugger,
        private readonly array $itemCardImagesAllowedMime,
        private readonly string $itemCardImagesDirectory
    ) {
    }

    public function handle(UploadFile $command): string
    {
        $uploadedFile = $command->getUploadedFile();

        if (false === \in_array($uploadedFile->getMimeType(), $this->itemCardImagesAllowedMime)) {
            $message = \sprintf(
                'Invalid mime type: %s, allowed are: %s.',
                $uploadedFile->getMimeType(),
                \implode(', ', $this->itemCardImagesAllowedMime)
            );
            throw new UploadException($message);
        }

        $newFilename = \sprintf(
            '%s-%s.%s',
            $this->slugger->slug($uploadedFile->getFilename()),
            uniqid(),
            $uploadedFile->guessExtension()
        );
        $uploadedFile->move($this->itemCardImagesDirectory, $newFilename);

        return $newFilename;
    }
}
