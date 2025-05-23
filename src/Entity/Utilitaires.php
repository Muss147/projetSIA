<?php

namespace App\Entity;

use App\Mapping\EntityBase;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilitairesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: UtilitairesRepository::class)]
class Utilitaires extends EntityBase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $valeur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    private ?self $parent = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    private Collection $children;

    /**
     * @var Collection<int, Projets>
     */
    #[ORM\OneToMany(targetEntity: Projets::class, mappedBy: 'secteurActivite')]
    private Collection $projets;

    /**
     * @var Collection<int, Contrats>
     */
    #[ORM\OneToMany(targetEntity: Contrats::class, mappedBy: 'typeTravaux')]
    private Collection $contractsUtilitaire;

    public function __construct()
    {
        $this->contractsUtilitaire = new ArrayCollection();
        $this->projets = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntityLibelle(): ?string
    {
        return $this->libelle;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(?string $valeur): static
    {
        $this->valeur = $valeur;

        return $this;
    }

    /**
     * @return Collection<int, Projets>
     */
    public function getProjets(): Collection
    {
        return $this->projets;
    }

    public function addProjet(Projets $projet): static
    {
        if (!$this->projets->contains($projet)) {
            $this->projets->add($projet);
            $projet->setSecteurActivite($this);
        }

        return $this;
    }

    public function removeProjet(Projets $projet): static
    {
        if ($this->projets->removeElement($projet)) {
            // set the owning side to null (unless already changed)
            if ($projet->getSecteurActivite() === $this) {
                $projet->setSecteurActivite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contrats>
     */
    public function getContractsUtilitaire(): Collection
    {
        return $this->contractsUtilitaire;
    }

    public function addContractsUtilitaire(Contrats $contractsUtilitaire): static
    {
        if (!$this->contractsUtilitaire->contains($contractsUtilitaire)) {
            $this->contractsUtilitaire->add($contractsUtilitaire);
            $contractsUtilitaire->setTypeTravaux($this);
        }

        return $this;
    }

    public function removeContractsUtilitaire(Contrats $contractsUtilitaire): static
    {
        if ($this->contractsUtilitaire->removeElement($contractsUtilitaire)) {
            // set the owning side to null (unless already changed)
            if ($contractsUtilitaire->getTypeTravaux() === $this) {
                $contractsUtilitaire->setTypeTravaux(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, Utilitaires>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Utilitaires $child): static
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(Utilitaires $child): static
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }
}
