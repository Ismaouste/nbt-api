<?php

namespace App\Entity;

use App\Repository\LineUpRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LineUpRepository::class)
 */
class LineUp
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Concert::class, inversedBy="lineUps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $concertId;

    /**
     * @ORM\ManyToOne(targetEntity=Artist::class, inversedBy="lineUps")
     */
    private $artistId;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConcertId(): ?concert
    {
        return $this->concertId;
    }

    public function setConcertId(?concert $concertId): self
    {
        $this->concertId = $concertId;

        return $this;
    }

    public function getArtistId(): ?Artist
    {
        return $this->artistId;
    }

    public function setArtistId(?Artist $artistId): self
    {
        $this->artistId = $artistId;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }
}