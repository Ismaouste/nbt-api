<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ArtistRepository::class)
 */
class Artist
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $bio;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $style;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\OneToMany(targetEntity=LineUp::class, mappedBy="artistId")
     */
    private $lineUps;

    public function __construct()
    {
        $this->lineUps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

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
            $lineUp->setArtistId($this);
        }

        return $this;
    }

    public function removeLineUp(LineUp $lineUp): self
    {
        if ($this->lineUps->contains($lineUp)) {
            $this->lineUps->removeElement($lineUp);
            // set the owning side to null (unless already changed)
            if ($lineUp->getArtistId() === $this) {
                $lineUp->setArtistId(null);
            }
        }

        return $this;
    }
}