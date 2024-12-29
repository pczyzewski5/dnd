<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Requirement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', nullable: false, options: ['unsigned' => false])]
    private int $id;

    #[ORM\Column(type: 'string', nullable: false, unique: true, length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', nullable: false, unique: true, length: 510)]
    private string $config;

    public function __construct(
        string $name,
        string $config
    ) {
        $this->name = $name;
        $this->config = $config;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getConfig(): string
    {
        return $this->config;
    }
}
