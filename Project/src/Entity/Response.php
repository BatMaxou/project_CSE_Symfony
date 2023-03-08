<?php

namespace App\Entity;

use App\Repository\ResponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResponseRepository::class)]
class Response
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idResponse = null;

    #[ORM\Column(length: 255)]
    private ?string $textResponse = null;

    #[ORM\ManyToOne(targetEntity: Survey::class)]
    #[ORM\JoinColumn(name: "id_survey", referencedColumnName: 'id_survey', nullable: false)]
    private ?Survey $survey = null;

    public function getIdResponse(): ?int
    {
        return $this->idResponse;
    }

    public function getTextResponse(): ?string
    {
        return $this->textResponse;
    }

    public function setTextResponse(string $textResponse): self
    {
        $this->textResponse = $textResponse;

        return $this;
    }

    public function getSurvey(): ?Survey
    {
        return $this->survey;
    }

    public function setSurvey(?Survey $survey): self
    {
        $this->survey = $survey;

        return $this;
    }
}
