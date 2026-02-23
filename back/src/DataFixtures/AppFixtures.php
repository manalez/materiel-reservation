<?php

namespace App\DataFixtures;

use App\Entity\Equipment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

// Remplit la base de données avec des données de test
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $items = [
            ['MacBook Pro 14"', 'MAC-001'],
            ['Canon EOS R5',    'CAM-001'],
            ['iPad Pro 12.9"',  'IPD-001'],
            ['Sony A7 IV',      'CAM-002'],
        ];

        foreach ($items as [$name, $ref]) {
            $equipment = new Equipment();
            $equipment->setName($name);
            $equipment->setReference($ref);
            $manager->persist($equipment);
        }

        $manager->flush();
    }
}