<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Car;
use App\Service\DataGeneratorService;
use Faker\Factory;

class CarFixtures extends Fixture
{
    private $dataGeneratorService;
    private $count;

    public function __construct(DataGeneratorService $dataGeneratorService, int $count = 20)
    {
        $this->dataGeneratorService = $dataGeneratorService;
        $this->count = $count;
    }

    public function load(ObjectManager $manager): void
    {
        $this->dataGeneratorService->generateCars($this->count);
    }
}
