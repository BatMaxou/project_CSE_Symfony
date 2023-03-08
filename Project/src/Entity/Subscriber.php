<?php

namespace App\Entity;

use App\Repository\SubscriberRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @UniqueEntity(fields={"emailSubscriber"}, message="There is already an account with this username")
 */
#[ORM\Entity(repositoryClass: SubscriberRepository::class)]
class Subscriber
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idSubscriber = null;

    #[ORM\Column(length: 255)]
    private ?string $emailSubscriber = null;

    #[ORM\Column]
    private ?bool $consentSubscriber = null;

    public function getIdSubscriber(): ?int
    {
        return $this->idSubscriber;
    }

    public function getEmailSubscriber(): ?string
    {
        return $this->emailSubscriber;
    }

    public function setEmailSubscriber(string $emailSubscriber): self
    {
        $this->emailSubscriber = $emailSubscriber;

        return $this;
    }

    public function isConsentSubscriber(): ?bool
    {
        return $this->consentSubscriber;
    }

    public function setConsentSubscriber(bool $consentSubscriber): self
    {
        $this->consentSubscriber = $consentSubscriber;

        return $this;
    }
}
