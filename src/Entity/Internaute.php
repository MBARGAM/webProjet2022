<?php

namespace App\Entity;

use App\Repository\InternauteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InternauteRepository::class)
 */
class Internaute
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
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="boolean")
     */
    private $newsletter;

    /**
     * @ORM\ManyToMany(targetEntity=Prestataire::class, inversedBy="internaute")
     */
    private $prestataire;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="internaute")
     */
    private $commentaire;

    /**
     * @ORM\OneToMany(targetEntity=Abus::class, mappedBy="internaute")
     */
    private $abus;

    /**
     * @ORM\Column(type="boolean")
     */
    private $bloque;

    /**
     * @ORM\OneToOne(targetEntity=Image::class, mappedBy="internaute", cascade={"persist", "remove"})
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity=Bloc::class, mappedBy="internaute")
     */
    private $bloc;

    /**
     * @ORM\OneToOne(targetEntity=Utilisateur::class, mappedBy="internaute", cascade={"persist", "remove"})
     */
    private $utilisateur;

    public function __construct()
    {
        $this->prestataire = new ArrayCollection();
        $this->commentaire = new ArrayCollection();
        $this->abus = new ArrayCollection();
        $this->bloc = new ArrayCollection();
    }

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function isNewsletter(): ?bool
    {
        return $this->newsletter;
    }

    public function setNewsletter(bool $newsletter): self
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * @return Collection<int, Prestataire>
     */
    public function getPrestataire(): Collection
    {
        return $this->prestataire;
    }

    public function addPrestataire(Prestataire $prestataire): self
    {
        if (!$this->prestataire->contains($prestataire)) {
            $this->prestataire[] = $prestataire;
        }

        return $this;
    }

    public function removePrestataire(Prestataire $prestataire): self
    {
        $this->prestataire->removeElement($prestataire);

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaire(): Collection
    {
        return $this->commentaire;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaire->contains($commentaire)) {
            $this->commentaire[] = $commentaire;
            $commentaire->setInternaute($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaire->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getInternaute() === $this) {
                $commentaire->setInternaute(null);
            }
        }

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
            $abu->setInternaute($this);
        }

        return $this;
    }

    public function removeAbu(Abus $abu): self
    {
        if ($this->abus->removeElement($abu)) {
            // set the owning side to null (unless already changed)
            if ($abu->getInternaute() === $this) {
                $abu->setInternaute(null);
            }
        }

        return $this;
    }

    public function isBloque(): ?bool
    {
        return $this->bloque;
    }

    public function setBloque(bool $bloque): self
    {
        $this->bloque = $bloque;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        // unset the owning side of the relation if necessary
        if ($image === null && $this->image !== null) {
            $this->image->setInternaute(null);
        }

        // set the owning side of the relation if necessary
        if ($image !== null && $image->getInternaute() !== $this) {
            $image->setInternaute($this);
        }

        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Bloc>
     */
    public function getBloc(): Collection
    {
        return $this->bloc;
    }

    public function addBloc(Bloc $bloc): self
    {
        if (!$this->bloc->contains($bloc)) {
            $this->bloc[] = $bloc;
            $bloc->addInternaute($this);
        }

        return $this;
    }

    public function removeBloc(Bloc $bloc): self
    {
        if ($this->bloc->removeElement($bloc)) {
            $bloc->removeInternaute($this);
        }

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        // unset the owning side of the relation if necessary
        if ($utilisateur === null && $this->utilisateur !== null) {
            $this->utilisateur->setInternaute(null);
        }

        // set the owning side of the relation if necessary
        if ($utilisateur !== null && $utilisateur->getInternaute() !== $this) {
            $utilisateur->setInternaute($this);
        }

        $this->utilisateur = $utilisateur;

        return $this;
    }
    public function __toString()
    {
        return $this->nom;
    }

}
