<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
    min: 2,
    max: 50,
    minMessage: 'Vous devez écrire au moins 2 caractères pour le prénom.',
    maxMessage: 'Vous devez écrire moins de 50 caractères pour le prénom.',
    )]
    #[Assert\NotBlank(
    message: 'Le prénom ne peut pas être vide, veuillez le renseigner.',
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
    min: 2,
    max: 50,
    minMessage: 'Vous devez écrire au moins 2 caractères pour le nom.',
    maxMessage: 'Vous devez écrire moins de 50 caractères pour le nom.',
    )]
    #[Assert\NotBlank(
    message: 'Le nom ne peut pas être vide, veuillez le renseigner.',
    )]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(
    message: 'Adresse mail invalid.',
    )]
    #[Assert\NotBlank(
    message: 'L\'adresse mail ne peut pas être vide, veuillez le renseigner.',
    )]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(
    min: 2,
    minMessage: 'Vous devez écrire au moins 2 caractères pour le message.',
    )]
    #[Assert\NotBlank(
    message: 'Le message ne peut pas être vide, veuillez le renseigner.',
    )]
    private ?string $message = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(
    message: 'Vous êtes obligé d\'accepter que le site utilise vos informations renseignés afin de prendre contact avec vous.',
    )]
    private ?bool $consent = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function isConsent(): ?bool
    {
        return $this->consent;
    }

    public function setConsent(?bool $consent): self
    {
        $this->consent = $consent;

        return $this;
    }
}