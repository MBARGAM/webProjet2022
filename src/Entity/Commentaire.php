<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
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
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cote;

    /**
     * @ORM\ManyToOne(targetEntity=Prestataire::class, inversedBy="commentaire")
     * @ORM\JoinColumn(nullable=false)
     */
    private $prestataire;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEncodage;

    /**
     * @ORM\ManyToOne(targetEntity=Internaute::class, inversedBy="commentaire")
     */
    private $internaute;

    /**
     * @ORM\OneToMany(targetEntity=Abus::class, mappedBy="commentaire")
     */
    private $abus;

    public function __construct()
    {
        $this->abus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getCote(): ?int
    {
        return $this->cote;
    }

    public function setCote(?int $cote): self
    {
        $this->cote = $cote;

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

    public function getDateEncodage(): ?\DateTimeInterface
    {
        return $this->dateEncodage;
    }

    public function setDateEncodage(\DateTimeInterface $dateEncodage): self
    {
        $this->dateEncodage = $dateEncodage;

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

    /**
     * @return Collection<int, Abus>
     */
    public function getAbus(): Collection
    {
        return $this->abus;
    }

    public function addAbu(Abus $abu): self
    {
        if (!$this->abus->contains($abu)) {
            $this->abus[] = $abu;
            $abu->setCommentaire($this);
        }

        return $this;
    }

    public function removeAbu(Abus $abu): self
    {
        if ($this->abus->removeElement($abu)) {
            // set the owning side to null (unless already changed)
            if ($abu->getCommentaire() === $this) {
                $abu->setCommentaire(null);
            }
        }

        return $this;
    }
}
