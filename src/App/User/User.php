<?php

declare(strict_types=1);

namespace App\User;

use DND\Domain\MergerTrait;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping;
use Symfony\Component\Uid\Uuid;

#[Mapping\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use MergerTrait;

    #[Mapping\Id]
    #[Mapping\Column(type: 'uuid', length: 36, nullable: false)]
    #[Mapping\CustomIdGenerator(class: Uuid::class)]
    private Uuid $id;

    #[Mapping\Column(type: 'string', length: 36, nullable: false)]
    private string $email;

    #[Mapping\Column(type: 'string', length: 36, nullable: false)]
    private string $username;

    #[Mapping\Column(type: 'json', nullable: false)]
    private array $roles;

    #[Mapping\Column(type: 'string', length: 255, nullable: false)]
    private string $password;

    #[Mapping\Column(type: 'boolean', nullable: false, options: ['default' => false])]
    private bool $isActive;

    #[Mapping\Column(type: 'datetime_immutable', nullable: false)]
    private \DateTimeImmutable $createdAt;

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
