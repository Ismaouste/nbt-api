<?php

namespace App\Entity;

use App\Repository\ConcertRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ConcertRepository::class)
 */
class Concert
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $title;



    /**
     * @ORM\Column(type="string", length=50)
     */
    private $category;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
    private $fee;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     * @Assert\NotBlank()
     */
    private $feeCurrency;

    /**
     * @ORM\OneToMany(targetEntity=LineUp::class, mappedBy="concertId", orphanRemoval=true)
     */
    private $lineUps;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $date_string;


    public function __construct()
    {
        $this->lineUps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }



    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getFee(): ?int
    {
        return $this->fee;
    }

    public function setFee(?int $fee): self
    {
        $this->fee = $fee;

        return $this;
    }

    public function getFeeCurrency(): ?string
    {
        return $this->feeCurrency;
    }

    public function setFeeCurrency(?string $feeCurrency): self
    {
        $this->feeCurrency = $feeCurrency;

        return $this;
    }

    /**
     * @return Collection|LineUp[]
     */
    public function getLineUps(): Collection
    {
        return $this->lineUps;
    }

    public function addLineUp(LineUp $lineUp): self
    {
        if (!$this->lineUps->contains($lineUp)) {
            $this->lineUps[] = $lineUp;
            $lineUp->setConcertId($this);
        }

        return $this;
    }

    public function removeLineUp(LineUp $lineUp): self
    {
        if ($this->lineUps->contains($lineUp)) {
            $this->lineUps->removeElement($lineUp);
            // set the owning side to null (unless already changed)
            if ($lineUp->getConcertId() === $this) {
                $lineUp->setConcertId(null);
            }
        }

        return $this;
    }

    public function getDateString(): ?string
    {
        return $this->date_string;
    }

    public function setDateString(string $date_string): self
    {
        $this->date_string = $date_string;

        return $this;
    }
}