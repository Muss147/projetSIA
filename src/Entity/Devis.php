<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
class Devis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $usine = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ouvrage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeTravaux = null;

    #[ORM\OneToOne(inversedBy: 'devis', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contrats $contrat = null;

    /**
     * @var Collection<int, DevisBPU>
     */
    #[ORM\OneToMany(targetEntity: DevisBPU::class, mappedBy: 'devis', orphanRemoval: true)]
    private Collection $devisBPUs;

    public function __construct()
    {
        $this->devisBPUs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getUsine(): ?string
    {
        return $this->usine;
    }

    public function setUsine(?string $usine): static
    {
        $this->usine = $usine;

        return $this;
    }

    public function getOuvrage(): ?string
    {
        return $this->ouvrage;
    }

    public function setOuvrage(?string $ouvrage): static
    {
        $this->ouvrage = $ouvrage;

        return $this;
    }

    public function getTypeTravaux(): ?string
    {
        return $this->typeTravaux;
    }

    public function setTypeTravaux(?string $typeTravaux): static
    {
        $this->typeTravaux = $typeTravaux;

        return $this;
    }

    public function getContrat(): ?Contrats
    {
        return $this->contrat;
    }

    public function setContrat(Contrats $contrat): static
    {
        $this->contrat = $contrat;

        return $this;
    }

    /**
     * @return Collection<int, DevisBPU>
     */
    public function getDevisBPUs(): Collection
    {
        return $this->devisBPUs;
    }

    public function addDevisBPUs(DevisBPU $devisBPUs): static
    {
        if (!$this->devisBPUs->contains($devisBPUs)) {
            $this->devisBPUs->add($devisBPUs);
            $devisBPUs->setDevis($this);
        }

        return $this;
    }

    public function removeDevisBPUs(DevisBPU $devisBPUs): static
    {
        if ($this->devisBPUs->removeElement($devisBPUs)) {
            // set the owning side to null (unless already changed)
            if ($devisBPUs->getDevis() === $this) {
                $devisBPUs->setDevis(null);
            }
        }

        return $this;
    }
}
