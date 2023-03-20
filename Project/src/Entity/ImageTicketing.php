<?php

namespace App\Entity;

use App\Repository\ImageTicketingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageTicketingRepository::class)]
class ImageTicketing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idImageTicketing = null;

    #[ORM\Column(length: 255)]
    private ?string $nameImageTicketing = null;

    #[ORM\ManyToOne(targetEntity: Ticketing::class, inversedBy: 'imageTicketings')]
    #[ORM\JoinColumn(name: 'id_ticketing', referencedColumnName: 'id_ticketing', nullable: false)]
    private ?Ticketing $ticketing = null;

    public function getIdImageTicketing(): ?int
    {
        return $this->idImageTicketing;
    }

    public function getNameImageTicketing(): ?string
    {
        return $this->nameImageTicketing;
    }

    public function setNameImageTicketing(string $nameImageTicketing): self
    {
        $this->nameImageTicketing = $nameImageTicketing;

        return $this;
    }

    public function getTicketing(): ?Ticketing
    {
        return $this->ticketing;
    }

    public function setTicketing(?Ticketing $ticketing): self
    {
        $this->ticketing = $ticketing;

        return $this;
    }
}