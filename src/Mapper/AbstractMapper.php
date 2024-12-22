<?php

declare(strict_types=1);

namespace App\Mapper;

use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use function count;

abstract class AbstractMapper
{
    public function __construct(
        private readonly ValidatorInterface $validator,
    ) {

    }

    protected function validate(object $dto): void
    {
        $violations = $this->validator->validate($dto);

        if (count($violations) > 0) {
            throw new ValidationFailedException($dto, $violations);
        }
    }

    protected function getValueOrNull(array $data, string $key): mixed
    {
        return $data[$key] ?? null;
    }

    protected function getArray(array $data, string $key): mixed
    {
        return array_key_exists($key, $data) && is_array($data[$key])
            ? $data[$key]
            : [];
    }
}
