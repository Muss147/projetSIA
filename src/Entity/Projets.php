<?php

namespace App\Entity;

use App\Mapping\EntityBase;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProjetsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ProjetsRepository::class)]
class Projets extends EntityBase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateFin = null;

    #[ORM\ManyToOne(inversedBy: 'projets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Clients $client = null;

    #[ORM\ManyToOne(inversedBy: 'projets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilitaires $secteurActivite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conducteurTravaux = null;

    #[ORM\Column(nullable: true)]
    private ?bool $tva = null;

    #[ORM\ManyToOne(inversedBy: 'projets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BusinessUnits $businessUnit = null;

    /**
     * @var Collection<int, Contrats>
     */
    #[ORM\OneToMany(targetEntity: Contrats::class, mappedBy: 'projet', orphanRemoval: true)]
    private Collection $contrats;

    #[ORM\Column(length: 255)]
    private ?string $statut = "En cours";

    public function __construct()
    {
        $this->contrats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntityLibelle(): ?string
    {
        return $this->nom;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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

    public function getDateDebut(): ?\DateTime
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTime $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTime
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTime $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getClient(): ?Clients
    {
        return $this->client;
    }

    public function setClient(?Clients $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getSecteurActivite(): ?Utilitaires
    {
        return $this->secteurActivite;
    }

    public function setSecteurActivite(?Utilitaires $secteurActivite): static
    {
        $this->secteurActivite = $secteurActivite;

        return $this;
    }

    public function getConducteurTravaux(): ?string
    {
        return $this->conducteurTravaux;
    }

    public function setConducteurTravaux(?string $conducteurTravaux): static
    {
        $this->conducteurTravaux = $conducteurTravaux;

        return $this;
    }

    public function isTva(): ?bool
    {
        return $this->tva;
    }

    public function setTva(?bool $tva): static
    {
        $this->tva = $tva;

        return $this;
    }

    public function getBusinessUnit(): ?BusinessUnits
    {
        return $this->businessUnit;
    }

    public function setBusinessUnit(?BusinessUnits $businessUnit): static
    {
        $this->businessUnit = $businessUnit;

        return $this;
    }

    /**
     * @return Collection<int, Contrats>
     */
    public function getContrats(): Collection
    {
        return $this->contrats;
    }

    public function addContrat(Contrats $contrat): static
    {
        if (!$this->contrats->contains($contrat)) {
            $this->contrats->add($contrat);
            $contrat->setProjet($this);
        }

        return $this;
    }

    public function removeContrat(Contrats $contrat): static
    {
        if ($this->contrats->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getProjet() === $this) {
                $contrat->setProjet(null);
            }
        }

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }
}
