<?php

declare(strict_types=1);

namespace App\Command;

class DeleteFileCommand
{
    public function __construct(private readonly string $filesDirectory)
    {
    }

    public function execute(string $filename): bool
    {
        $filepath = $this->filesDirectory . '/' . $filename;

        if (false === \file_exists($filepath)) {
            throw new \Exception('Cannot delete: ' . $filepath . ' file, because it is not exists.');
        }

        return \unlink($filepath);
    }
}
