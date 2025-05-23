<?php

namespace App\Entity;

use App\Mapping\EntityBase;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ContratsRepository;

#[ORM\Entity(repositoryClass: ContratsRepository::class)]
class Contrats extends EntityBase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateFin = null;

    #[ORM\ManyToOne(inversedBy: 'contractsUtilitaire')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilitaires $typeTravaux = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tauxGarantie = null;

    #[ORM\ManyToOne(inversedBy: 'contrats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Clients $client = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = "En cours";

    #[ORM\ManyToOne(inversedBy: 'contrats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Projets $projet = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'contrats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ChefChantier $chefChantier = null;

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

    public function getTypeTravaux(): ?Utilitaires
    {
        return $this->typeTravaux;
    }

    public function setTypeTravaux(?Utilitaires $typeTravaux): static
    {
        $this->typeTravaux = $typeTravaux;

        return $this;
    }

    public function getTauxGarantie(): ?string
    {
        return $this->tauxGarantie;
    }

    public function setTauxGarantie(?string $tauxGarantie): static
    {
        $this->tauxGarantie = $tauxGarantie;

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

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

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

    public function getProjet(): ?Projets
    {
        return $this->projet;
    }

    public function setProjet(?Projets $projet): static
    {
        $this->projet = $projet;

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

    public function getChefChantier(): ?ChefChantier
    {
        return $this->chefChantier;
    }

    public function setChefChantier(?ChefChantier $chefChantier): static
    {
        $this->chefChantier = $chefChantier;

        return $this;
    }
}
