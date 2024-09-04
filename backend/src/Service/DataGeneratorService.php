<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Car;
use App\Entity\Driver;
use Faker\Factory;

class DataGeneratorService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function generateCars(int $count = 20): void
    {
        $faker = Factory::create('ru_RU');

        for ($i = 0; $i < $count; $i++) {
            $car = new Car();
            $car->setLicensePlate($this->generateRussianLicensePlate($faker));
            $car->setBrand($faker->randomElement(['Лада', 'ГАЗ', 'Toyota', 'Honda', 'Ford', 'Volkswagen', 'Nissan', 'BMW', 'Mercedes', 'Audi']));
            $car->setModel($faker->word);
            
            $this->entityManager->persist($car);
        }

        $this->entityManager->flush();
    }

    private function generateRussianLicensePlate($faker): string
    {
        $letters = ['А', 'В', 'Е', 'К', 'М', 'Н', 'О', 'Р', 'С', 'Т', 'У', 'Х'];
        return $faker->randomElement($letters) . 
               $faker->numberBetween(100, 999) . 
               $faker->randomElement($letters) . 
               $faker->randomElement($letters) . 
               $faker->numberBetween(1, 199);
    }

    public function generateDrivers(int $count = 20): void
    {
        $faker = Factory::create('ru_RU');

        $carIds = $this->entityManager->getRepository(Car::class)->findAll();

        for ($i = 0; $i < $count; $i++) {
            $driver = new Driver();
            $driver->setName($faker->name);
            $driver->setBirthday($faker->dateTimeBetween('-60 years', '-18 years'));

            $randomCar = $faker->randomElement($carIds);
            $driver->setCar($randomCar);
            
            $this->entityManager->persist($driver);
        }

        $this->entityManager->flush();
    }
}