<?php

namespace App\Entity;

use App\Repository\AbusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AbusRepository::class)
 */
class Abus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEncodage;

    /**
     * @ORM\ManyToOne(targetEntity=Commentaire::class, inversedBy="abus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity=Internaute::class, inversedBy="abus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $internaute;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateEncodage(): ?\DateTimeInterface
    {
        return $this->dateEncodage;
    }

    public function setDateEncodage(\DateTimeInterface $dateEncodage): self
    {
        $this->dateEncodage = $dateEncodage;

        return $this;
    }

    public function getCommentaire(): ?Commentaire
    {
        return $this->commentaire;
    }

    public function setCommentaire(?Commentaire $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getInternaute(): ?Internaute
    {
        return $this->internaute;
    }

    public function setInternaute(?Internaute $internaute): self
    {
        $this->internaute = $internaute;

        return $this;
    }
}
