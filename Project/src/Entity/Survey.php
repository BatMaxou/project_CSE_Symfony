<?php

namespace App\Entity;

use App\Repository\SurveyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SurveyRepository::class)]
class Survey
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idSurvey = null;

    #[ORM\Column(length: 255)]
    private ?string $questionSurvey = null;

    #[ORM\Column]
    private ?bool $isActiveSurvey = null;

    public function getIdSurvey(): ?int
    {
        return $this->idSurvey;
    }

    public function getQuestionSurvey(): ?string
    {
        return $this->questionSurvey;
    }

    public function setQuestionSurvey(string $questionSurvey): self
    {
        $this->questionSurvey = $questionSurvey;

        return $this;
    }

    public function isIsActiveSurvey(): ?bool
    {
        return $this->isActiveSurvey;
    }

    public function setIsActiveSurvey(?bool $isActiveSurvey): self
    {
        $this->isActiveSurvey = $isActiveSurvey;

        return $this;
    }
}
