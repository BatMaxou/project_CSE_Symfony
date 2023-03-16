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
    private ?int $idContact = null;

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
    private ?string $nameContact = null;

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
    private ?string $firstnameContact = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(
        message: 'Adresse mail invalid.',
    )]
    #[Assert\NotBlank(
        message: 'L\'adresse mail ne peut pas être vide, veuillez le renseigner.',
    )]
    private ?string $emailContact = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(
        min: 2,
        minMessage: 'Vous devez écrire au moins 2 caractères pour le message.',
    )]
    #[Assert\NotBlank(
        message: 'Le message ne peut pas être vide, veuillez le renseigner.',
    )]
    private ?string $messageContact = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(
        message: 'Vous êtes obligé d\'accepter que le site utilise vos informations renseignés afin de prendre contact avec vous.',
    )]
    private ?bool $consentContact = null;

    public function getIdContact(): ?int
    {
        return $this->idContact;
    }

    public function getNameContact(): ?string
    {
        return $this->nameContact;
    }

    public function setNameContact(string $nameContact): self
    {
        $this->nameContact = $nameContact;

        return $this;
    }

    public function getFirstnameContact(): ?string
    {
        return $this->firstnameContact;
    }

    public function setFirstnameContact(string $firstnameContact): self
    {
        $this->firstnameContact = $firstnameContact;

        return $this;
    }

    public function getEmailContact(): ?string
    {
        return $this->emailContact;
    }

    public function setEmailContact(string $emailContact): self
    {
        $this->emailContact = $emailContact;

        return $this;
    }

    public function getMessageContact(): ?string
    {
        return $this->messageContact;
    }

    public function setMessageContact(string $messageContact): self
    {
        $this->messageContact = $messageContact;

        return $this;
    }

    public function isConsentContact(): ?bool
    {
        return $this->consentContact;
    }

    public function setConsentContact(?bool $consentContact): self
    {
        $this->consentContact = $consentContact;

        return $this;
    }
}
