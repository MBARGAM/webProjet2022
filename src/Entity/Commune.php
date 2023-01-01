<?php

namespace App\Entity;

use App\Repository\CommuneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommuneRepository::class)
 */
class Commune
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commune;

    /**
     * @ORM\OneToMany(targetEntity=Localite::class, mappedBy="commune")
     */
    private $localite;

    /**
     * @ORM\ManyToOne(targetEntity=CodePostal::class, inversedBy="commune")
     */
    private $cp;

    /**
     * @ORM\OneToMany(targetEntity=Utilisateur::class, mappedBy="commune")
     */
    private $utilisateur;

    public function __construct()
    {
        $this->localite = new ArrayCollection();
        $this->utilisateur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommune(): ?string
    {
        return $this->commune;
    }

    public function setCommune(?string $commune): self
    {
        $this->commune = $commune;

        return $this;
    }

    /**
     * @return Collection<int, Localite>
     */
    public function getLocalite(): Collection
    {
        return $this->localite;
    }

    public function addLocalite(Localite $localite): self
    {
        if (!$this->localite->contains($localite)) {
            $this->localite[] = $localite;
            $localite->setCommune($this);
        }

        return $this;
    }

    public function removeLocalite(Localite $localite): self
    {
        if ($this->localite->removeElement($localite)) {
            // set the owning side to null (unless already changed)
            if ($localite->getCommune() === $this) {
                $localite->setCommune(null);
            }
        }

        return $this;
    }

    public function getCp(): ?CodePostal
    {
        return $this->cp;
    }

    public function setCp(?CodePostal $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateur(): Collection
    {
        return $this->utilisateur;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateur->contains($utilisateur)) {
            $this->utilisateur[] = $utilisateur;
            $utilisateur->setCommune($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateur->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getCommune() === $this) {
                $utilisateur->setCommune(null);
            }
        }

        return $this;
    }
}
