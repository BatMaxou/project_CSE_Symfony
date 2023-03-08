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
    private ?int $idCkeditor = null;

    #[ORM\Column(length: 255)]
    private ?string $namePageCkeditor = null;

    #[ORM\Column(length: 255)]
    private ?string $zoneCkeditor = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contentCkeditor = null;

    public function getIdCkeditor(): ?int
    {
        return $this->idCkeditor;
    }

    public function getNamePageCkeditor(): ?string
    {
        return $this->namePageCkeditor;
    }

    public function setNamePageCkeditor(string $namePageCkeditor): self
    {
        $this->namePageCkeditor = $namePageCkeditor;

        return $this;
    }

    public function getZoneCkeditor(): ?string
    {
        return $this->zoneCkeditor;
    }

    public function setZoneCkeditor(string $zoneCkeditor): self
    {
        $this->zoneCkeditor = $zoneCkeditor;

        return $this;
    }

    public function getContentCkeditor(): ?string
    {
        return $this->contentCkeditor;
    }

    public function setContentCkeditor(string $contentCkeditor): self
    {
        $this->contentCkeditor = $contentCkeditor;

        return $this;
    }
}
