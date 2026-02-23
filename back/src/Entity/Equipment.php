<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\ORM\Mapping as ORM;

// Cette classe représente la table "equipment" dans la base de données
#[ORM\Entity(repositoryClass: EquipmentRepository::class)]
class Equipment
{
    // Identifiant auto-généré (1, 2, 3..)
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Nom du matériel ex: "MacBook Pro"
    #[ORM\Column(length: 255)]
    private string $name;

    // Code unique ex: "MAC-001"
    #[ORM\Column(length: 100, unique: true)]
    private string $reference;

    public function getId(): ?int { return $this->id; }

    public function getName(): string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }

    public function getReference(): string { return $this->reference; }
    public function setReference(string $reference): self { $this->reference = $reference; return $this; }
}