<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\RequirementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RequirementRepository::class)]
class Requirement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer', nullable: false, options: ['unsigned' => false])]
    private int $id;

    #[ORM\Column(type: 'string', nullable: false, unique: false, length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', nullable: true, unique: true, length: 510)]
    private ?string $config;

    public function __construct(
        string $name,
        ?string $config = null
    ) {
        $this->name = $name;
        $this->config = $config;
    }

    public function getId(): int
    {
        return $this->id;
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
