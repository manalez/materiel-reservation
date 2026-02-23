<?php

namespace App\Controller;

use App\Repository\EquipmentRepository;
use App\Service\ReservationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// Gère les requêtes HTTP et retourne des réponses JSON
class ReservationController extends AbstractController
{
    // Retourne la liste de tous les équipements
    // URL : GET http://localhost:8080/api/equipments
    #[Route('/api/equipments', name: 'api_equipments', methods: ['GET'])]
    public function listEquipments(EquipmentRepository $equipmentRepo): JsonResponse
    {
        $equipments = $equipmentRepo->findAll();

        $data = array_map(fn($e) => [
            'id'        => $e->getId(),
            'name'      => $e->getName(),
            'reference' => $e->getReference(),
        ], $equipments);

        return $this->json($data);
    }

    // Reçoit le formulaire du front et crée la réservation
    // URL : POST http://localhost:8080/api/reservations
    #[Route('/api/reservations', name: 'api_reservations_create', methods: ['POST'])]
    public function create(Request $request, ReservationService $reservationService): JsonResponse
    {
        // Lit le JSON envoyé par le front
        $data = json_decode($request->getContent(), true);

        $result = $reservationService->createReservation($data);

        if (isset($result['error'])) {
            return $this->json($result, Response::HTTP_BAD_REQUEST);
        }

        return $this->json($result, Response::HTTP_CREATED);
    }
}