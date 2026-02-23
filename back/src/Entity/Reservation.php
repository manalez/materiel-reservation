<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

// Cette classe représente la table "reservation" dans la base de données
#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    // Identifiant auto-généré (1, 2, 3...)
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Date de début ex: 23/02/2026
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private \DateTimeInterface $startDate;

    // Date de fin ex: 27/02/2026
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private \DateTimeInterface $endDate;

    // Email de l'employé qui réserve
    #[ORM\Column(length: 255)]
    private string $userEmail;

    // Lien vers le matériel réservé (clé étrangère vers equipment)
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private Equipment $equipment;

    public function getId(): ?int { return $this->id; }

    public function getStartDate(): \DateTimeInterface { return $this->startDate; }
    public function setStartDate(\DateTimeInterface $startDate): self { $this->startDate = $startDate; return $this; }

    public function getEndDate(): \DateTimeInterface { return $this->endDate; }
    public function setEndDate(\DateTimeInterface $endDate): self { $this->endDate = $endDate; return $this; }

    public function getUserEmail(): string { return $this->userEmail; }
    public function setUserEmail(string $userEmail): self { $this->userEmail = $userEmail; return $this; }

    public function getEquipment(): Equipment { return $this->equipment; }
    public function setEquipment(Equipment $equipment): self { $this->equipment = $equipment; return $this; }
}