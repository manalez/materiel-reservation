<?php

namespace App\Service;

use App\Entity\Reservation;
use App\Repository\EquipmentRepository;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;

// Contient toute la logique métier, séparé du contrôleur pour garder le code propre
class ReservationService
{
    public function __construct(
        private EntityManagerInterface $em,
        private ReservationRepository $reservationRepo,
        private EquipmentRepository $equipmentRepo,
    ) {}

    // Crée une réservation après avoir vérifié toutes les règles
    // Retourne ['success'  true] ou ['error' 'message']
    public function createReservation(array $data): array
    {
        // Vérifie que tous les champs sont présents
        if (empty($data['equipment_id']) || empty($data['start_date']) || empty($data['end_date']) || empty($data['user_email'])) {
            return ['error' => 'Tous les champs sont obligatoires.'];
        }

        // Convertit les dates reçues en objets DateTime
        $start = \DateTime::createFromFormat('Y-m-d', $data['start_date']);
        $end   = \DateTime::createFromFormat('Y-m-d', $data['end_date']);

        if (!$start || !$end) {
            return ['error' => 'Format de date invalide.'];
        }

        // La date de fin doit être après la date de début
        if ($end <= $start) {
            return ['error' => 'La date de fin doit être après la date de début.'];
        }

        // Cherche le matériel en base de données
        $equipment = $this->equipmentRepo->find($data['equipment_id']);
        if (!$equipment) {
            return ['error' => 'Équipement introuvable.'];
        }

        // Vérifie qu'il n'y a pas de réservation qui bloque cette période
        $conflicts = $this->reservationRepo->findConflicts($equipment->getId(), $start, $end);
        if (count($conflicts) > 0) {
            return ['error' => 'Ce matériel est déjà réservé sur cette période.'];
        }

        // Tout est OK on crée et on sauvegarde la réservation
        $reservation = new Reservation();
        $reservation->setEquipment($equipment);
        $reservation->setStartDate($start);
        $reservation->setEndDate($end);
        $reservation->setUserEmail($data['user_email']);

        $this->em->persist($reservation);
        $this->em->flush();

        return ['success' => true, 'message' => 'Réservation créée avec succès !'];
    }
}