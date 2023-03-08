<?php

namespace App\Entity;

use App\Repository\PartnershipRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PartnershipRepository::class)]
class Partnership
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idPartnership = null;

    #[ORM\Column(length: 255)]
    private ?string $namePartnership = null;

    #[ORM\Column(length: 255)]
    private ?string $imagePartnership = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descriptionPartnership = null;

    #[ORM\Column(length: 255)]
    private ?string $linkPartnership = null;

    public function getIdPartnership(): ?int
    {
        return $this->idPartnership;
    }

    public function getNamePartnership(): ?string
    {
        return $this->namePartnership;
    }

    public function setNamePartnership(string $namePartnership): self
    {
        $this->namePartnership = $namePartnership;

        return $this;
    }

    public function getImagePartnership(): ?string
    {
        return $this->imagePartnership;
    }

    public function setImagePartnership(string $imagePartnership): self
    {
        $this->imagePartnership = $imagePartnership;

        return $this;
    }

    public function getDescriptionPartnership(): ?string
    {
        return $this->descriptionPartnership;
    }

    public function setDescriptionPartnership(string $descriptionPartnership): self
    {
        $this->descriptionPartnership = $descriptionPartnership;

        return $this;
    }

    public function getLinkPartnership(): ?string
    {
        return $this->linkPartnership;
    }

    public function setLinkPartnership(string $linkPartnership): self
    {
        $this->linkPartnership = $linkPartnership;

        return $this;
    }
}
