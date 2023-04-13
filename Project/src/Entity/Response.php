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
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $text = null;

    #[ORM\ManyToOne(targetEntity: Survey::class)]
    #[ORM\JoinColumn(name: "id_survey", referencedColumnName: 'id', nullable: false)]
    private Survey $survey;

    #[ORM\Column]
    private ?int $nbVote = null;

    public function getSurvey(): Survey
    {
        return $this->survey;
    }

    public function setSurvey(Survey $survey): self
    {
        $this->survey = $survey;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getNbVote(): ?int
    {
        return $this->nbVote;
    }

    public function setNbVote(int $nbVote): self
    {
        $this->nbVote = $nbVote;

        return $this;
    }
}
