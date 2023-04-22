<?php

namespace App\Entity;

use App\Repository\CkeditorRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @UniqueEntity(fields={"zoneCkeditor"}, message="There is already a zone affected !")
 */
#[ORM\Entity(repositoryClass: CkeditorRepository::class)]
class Ckeditor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $pageName = null;

    #[ORM\Column(length: 255)]
    private ?string $zone = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPageName(): ?string
    {
        return $this->pageName;
    }

    public function setPageName(string $pageName): self
    {
        $this->pageName = $pageName;

        return $this;
    }

    public function getZone(): ?string
    {
        return $this->zone;
    }

    public function setZone(string $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
