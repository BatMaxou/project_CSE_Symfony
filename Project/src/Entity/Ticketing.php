<?php

namespace App\Entity;

use App\Repository\TicketingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketingRepository::class)]
class Ticketing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idTicketing = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameTicketing = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $textTicketing = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateStartTicketing = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateEndTicketing = null;

    #[ORM\Column(nullable: true)]
    private ?int $numberMinPlaceTicketing = null;

    #[ORM\Column(nullable: true)]
    private ?int $orderNumberTicketing = null;

    #[ORM\Column(length: 255)]
    private ?string $typeTicketing = null;

    public function getIdTicketing(): ?int
    {
        return $this->idTicketing;
    }

    public function getNameTicketing(): ?string
    {
        return $this->nameTicketing;
    }

    public function setNameTicketing(string $nameTicketing): self
    {
        $this->nameTicketing = $nameTicketing;

        return $this;
    }

    public function getTextTicketing(): ?string
    {
        return $this->textTicketing;
    }

    public function setTextTicketing(string $textTicketing): self
    {
        $this->textTicketing = $textTicketing;

        return $this;
    }

    public function getDateStartTicketing(): ?\DateTimeInterface
    {
        return $this->dateStartTicketing;
    }

    public function setDateStartTicketing(?\DateTimeInterface $dateStartTicketing): self
    {
        $this->dateStartTicketing = $dateStartTicketing;

        return $this;
    }

    public function getDateEndTicketing(): ?\DateTimeInterface
    {
        return $this->dateEndTicketing;
    }

    public function setDateEndTicketing(?\DateTimeInterface $dateEndTicketing): self
    {
        $this->dateEndTicketing = $dateEndTicketing;

        return $this;
    }

    public function getNumberMinPlaceTicketing(): ?int
    {
        return $this->numberMinPlaceTicketing;
    }

    public function setNumberMinPlaceTicketing(?int $numberMinPlaceTicketing): self
    {
        $this->numberMinPlaceTicketing = $numberMinPlaceTicketing;

        return $this;
    }

    public function getOrderNumberTicketing(): ?int
    {
        return $this->orderNumberTicketing;
    }

    public function setOrderNumberTicketing(?int $orderNumberTicketing): self
    {
        $this->orderNumberTicketing = $orderNumberTicketing;

        return $this;
    }

    public function getTypeTicketing(): ?string
    {
        return $this->typeTicketing;
    }

    public function setTypeTicketing(string $typeTicketing): self
    {
        $this->typeTicketing = $typeTicketing;

        return $this;
    }
}
