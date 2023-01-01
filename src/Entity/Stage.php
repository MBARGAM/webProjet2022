<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StageRepository::class)
 */
class Stage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $tarif;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $infosComplementaires;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="date")
     */
    private $debutAffichage;

    /**
     * @ORM\Column(type="date")
     */
    private $finAffichage;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity=Prestataire::class, inversedBy="stage")
     * @ORM\JoinColumn(nullable=false)
     */
    private $prestataire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTarif(): ?float
    {
        return $this->tarif;
    }

    public function setTarif(float $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getInfosComplementaires(): ?string
    {
        return $this->infosComplementaires;
    }

    public function setInfosComplementaires(?string $infosComplementaires): self
    {
        $this->infosComplementaires = $infosComplementaires;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDebutAffichage(): ?\DateTimeInterface
    {
        return $this->debutAffichage;
    }

    public function setDebutAffichage(\DateTimeInterface $debutAffichage): self
    {
        $this->debutAffichage = $debutAffichage;

        return $this;
    }

    public function getFinAffichage(): ?\DateTimeInterface
    {
        return $this->finAffichage;
    }

    public function setFinAffichage(\DateTimeInterface $finAffichage): self
    {
        $this->finAffichage = $finAffichage;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getPrestataire(): ?Prestataire
    {
        return $this->prestataire;
    }

    public function setPrestataire(?Prestataire $prestataire): self
    {
        $this->prestataire = $prestataire;

        return $this;
    }
}
