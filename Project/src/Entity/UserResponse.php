<?php

namespace App\Entity;

use App\Repository\UserResponseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserResponseRepository::class)]
class UserResponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idUserResponse = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datetimeUserResponse = null;

    #[ORM\ManyToOne(targetEntity: Response::class)]
    #[ORM\JoinColumn(name: "id_response", referencedColumnName: 'id_response', nullable: false)]
    private ?Response $response = null;

    public function __construct()
    {
        $this->datetimeUserResponse = new \DateTimeImmutable();
    }

    public function getIdUserResponse(): ?int
    {
        return $this->idUserResponse;
    }

    public function getDateUserResponse(): ?\DateTimeInterface
    {
        return $this->datetimeUserResponse;
    }

    public function setDateUserResponse(\DateTimeInterface $dateUserResponse): self
    {
        $this->datetimeUserResponse = $dateUserResponse;

        return $this;
    }

    public function getResponse(): ?Response
    {
        return $this->response;
    }

    public function setResponse(?Response $response): self
    {
        $this->response = $response;

        return $this;
    }
}
