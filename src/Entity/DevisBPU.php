<?php

namespace App\Entity;

use App\Repository\DevisBPURepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevisBPURepository::class)]
class DevisBPU
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'devis')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BPU $bpu = null;

    #[ORM\ManyToOne(inversedBy: 'devisBPUs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Devis $devis = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getBpu(): ?BPU
    {
        return $this->bpu;
    }

    public function setBpu(?BPU $bpu): static
    {
        $this->bpu = $bpu;

        return $this;
    }

    public function getDevis(): ?Devis
    {
        return $this->devis;
    }

    public function setDevis(?Devis $devis): static
    {
        $this->devis = $devis;

        return $this;
    }
}
