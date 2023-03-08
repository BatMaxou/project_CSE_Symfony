<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @UniqueEntity(fields={"emailAdmin"}, message="There is already an account with this email !")
 */
#[ORM\Entity(repositoryClass: AdminRepository::class)]
class Admin implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idAdmin = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $emailAdmin = null;

    #[ORM\Column]
    private array $rolesAdmin = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $passwordAdmin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastLoginAdmin = null;

    public function getIdAdmin(): ?int
    {
        return $this->idAdmin;
    }

    public function getEmail(): ?string
    {
        return $this->emailAdmin;
    }

    public function setEmail(string $emailAdmin): self
    {
        $this->emailAdmin = $emailAdmin;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->emailAdmin;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $rolesAdmin = $this->rolesAdmin;
        // guarantee every user at least has ROLE_USER
        $rolesAdmin[] = 'ROLE_USER';

        return array_unique($rolesAdmin);
    }

    public function setRoles(array $rolesAdmin): self
    {
        $this->rolesAdmin = $rolesAdmin;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->passwordAdmin;
    }

    public function setPassword(string $passwordAdmin): self
    {
        $this->passwordAdmin = $passwordAdmin;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastLoginAdmin(): ?\DateTimeInterface
    {
        return $this->lastLoginAdmin;
    }

    public function setLastLoginAdmin(?\DateTimeInterface $lastLoginAdmin): self
    {
        $this->lastLoginAdmin = $lastLoginAdmin;

        return $this;
    }
}
