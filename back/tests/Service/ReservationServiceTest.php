<?php

namespace App\Tests\Service;

use App\Entity\Equipment;
use App\Repository\EquipmentRepository;
use App\Repository\ReservationRepository;
use App\Service\ReservationService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class ReservationServiceTest extends TestCase
{
    // Crée un service avec de faux objets à la place de la vraie base de données
    private function makeService(array $conflicts = [], ?Equipment $equipment = null): ReservationService
    {
        $em = $this->createMock(EntityManagerInterface::class);

        $reservationRepo = $this->createMock(ReservationRepository::class);
        $reservationRepo->method('findConflicts')->willReturn($conflicts);

        $equipmentRepo = $this->createMock(EquipmentRepository::class);
        $equipmentRepo->method('find')->willReturn($equipment);

        return new ReservationService($em, $reservationRepo, $equipmentRepo);
    }

    // Crée un faux équipement pour les tests
    private function makeEquipment(): Equipment
    {
        $e = new Equipment();
        $e->setName('MacBook Pro');
        $e->setReference('MAC-001');
        return $e;
    }

    // Test 1 : champs manquants doit retourner une erreur
    public function testMissingFieldsReturnsError(): void
    {
        $service = $this->makeService();
        $result = $service->createReservation([]);
        $this->assertArrayHasKey('error', $result);
    }

    // Test 2 : date de fin avant date de début doit retourner une erreur
    public function testEndBeforeStartReturnsError(): void
    {
        $service = $this->makeService([], $this->makeEquipment());
        $result = $service->createReservation([
            'equipment_id' => 1,
            'start_date'   => '2025-06-10',
            'end_date'     => '2025-06-05',
            'user_email'   => 'test@test.com',
        ]);
        $this->assertArrayHasKey('error', $result);
    }

    // Test 3 : matériel déjà réservé doit retourner une erreur
    public function testConflictReturnsError(): void
    {
        $service = $this->makeService(['reservation_existante'], $this->makeEquipment());
        $result = $service->createReservation([
            'equipment_id' => 1,
            'start_date'   => '2025-06-01',
            'end_date'     => '2025-06-05',
            'user_email'   => 'test@test.com',
        ]);
        $this->assertArrayHasKey('error', $result);
    }

    // Test 4 : tout est valide doit retourner un succès
    public function testValidReservationReturnsSuccess(): void
    {
        $service = $this->makeService([], $this->makeEquipment());
        $result = $service->createReservation([
            'equipment_id' => 1,
            'start_date'   => '2025-06-01',
            'end_date'     => '2025-06-05',
            'user_email'   => 'test@test.com',
        ]);
        $this->assertTrue($result['success']);
    }
}