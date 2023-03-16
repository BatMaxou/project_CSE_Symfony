<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idContact = null;

    #[ORM\Column(length: 255)]
    private ?string $nameContact = null;

    #[ORM\Column(length: 255)]
    private ?string $firstnameContact = null;

    #[ORM\Column(length: 255)]
    private ?string $emailContact = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $messageContact = null;

    #[ORM\Column(nullable: true)]
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
