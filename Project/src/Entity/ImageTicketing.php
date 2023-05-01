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
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Ticketing::class, inversedBy: 'imageTicketings')]
    #[ORM\JoinColumn(name: 'id_ticketing', referencedColumnName: 'id', nullable: false)]
    private ?Ticketing $ticketing = null;

    #[ORM\Column]
    private ?int $numero = null;

    public function getTicketing(): ?Ticketing
    {
        return $this->ticketing;
    }

    public function setTicketing(?Ticketing $ticketing): self
    {
        $this->ticketing = $ticketing;

        return $this;
    }

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

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }
}