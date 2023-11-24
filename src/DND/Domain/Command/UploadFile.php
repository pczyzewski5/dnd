<?php

declare(strict_types=1);

namespace DND\Domain\Command;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFile
{
    private UploadedFile $uploadedFile;

    public function __construct(UploadedFile $uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;
    }

    public function getUploadedFile(): UploadedFile
    {
        return $this->uploadedFile;
    }
}
