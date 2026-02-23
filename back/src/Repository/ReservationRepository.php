<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

// Gère toutes les requêtes SQL liées à la table reservation
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    // Vérifie si un équipement est déjà réservé sur une période donnée
    public function findConflicts(int $equipmentId, \DateTimeInterface $start, \DateTimeInterface $end): array
    {
        return $this->createQueryBuilder('r')
            ->where('r.equipment = :equipment')
            ->andWhere('r.startDate <= :end')
            ->andWhere('r.endDate >= :start')
            ->setParameter('equipment', $equipmentId)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getResult();
    }
}