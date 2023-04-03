<?php

namespace App\Entity;

use App\Repository\TicketingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketingRepository::class)]
class Ticketing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateStart = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateEnd = null;

    #[ORM\Column(nullable: true)]
    private ?int $numberMinPlace = null;

    #[ORM\Column(nullable: true)]
    private ?int $orderNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCreate = null;

    #[ORM\OneToOne(targetEntity: Partnership::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "id_partnership", referencedColumnName: 'id', nullable: true)]
    private ?Partnership $partnership = null;

    #[ORM\OneToMany(mappedBy: 'ticketing', targetEntity: ImageTicketing::class)]
    private Collection $imageTicketings;

    public function __construct()
    {
        $this->imageTicketings = new ArrayCollection();
    }

    public function getPartnership(): ?Partnership
    {
        return $this->partnership;
    }

    public function setPartnership(?Partnership $partnership): self
    {
        $this->partnership = $partnership;

        return $this;
    }

    /**
     * @return Collection<int, ImageTicketing>
     */
    public function getImageTicketings(): Collection
    {
        return $this->imageTicketings;
    }

    public function addImageTicketing(ImageTicketing $imageTicketing): self
    {
        if (!$this->imageTicketings->contains($imageTicketing)) {
            $this->imageTicketings->add($imageTicketing);
            $imageTicketing->setTicketing($this);
        }

        return $this;
    }

    public function removeImageTicketing(ImageTicketing $imageTicketing): self
    {
        if ($this->imageTicketings->removeElement($imageTicketing)) {
            // set the owning side to null (unless already changed)
            if ($imageTicketing->getTicketing() === $this) {
                $imageTicketing->setTicketing(null);
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(?\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getNumberMinPlace(): ?int
    {
        return $this->numberMinPlace;
    }

    public function setNumberMinPlace(?int $numberMinPlace): self
    {
        $this->numberMinPlace = $numberMinPlace;

        return $this;
    }

    public function getOrderNumber(): ?int
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(?int $orderNumber): self
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->dateCreate;
    }

    public function setDateCreate(?\DateTimeInterface $dateCreate): self
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }
}
