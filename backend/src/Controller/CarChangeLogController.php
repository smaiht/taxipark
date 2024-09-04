<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\CarChangeLog;
use App\Entity\Driver;
use App\Repository\CarChangeLogRepository;
use App\Repository\CarRepository;
use App\Repository\DriverRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[Route('/car-change-logs', name: 'api_car_change_log_')]
class CarChangeLogController extends AbstractController
{
    private function carInfo(?Car $car): ?array
    {
        if (!$car) {
            return null;
        }
        return [
            'id' => $car->getId(),
            'licensePlate' => $car->getLicensePlate(),
            'brand' => $car->getBrand(),
            'model' => ucfirst($car->getModel()),
        ];
    }
    
    private function driverInfo(Driver $driver): array
    {
        return [
            'id' => $driver->getId(),
            'name' => $driver->getName(),
            'birthday' => $driver->getBirthday()->format('Y-m-d'),
        ];
    }
    
    private function info(CarChangeLog $carChangeLog): array
    {
        return [
            'id' => $carChangeLog->getId(),
            'changeDate' => $carChangeLog->getChangeDate()->format('Y-m-d H:i:s'),
            'oldCar' => $this->carInfo($carChangeLog->getOldCar()),
            'newCar' => $this->carInfo($carChangeLog->getNewCar()),
            'driver' => $this->driverInfo($carChangeLog->getDriver()),
        ];
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(CarChangeLogRepository $repository): JsonResponse
    {
        $logs = $repository->findAll();

        $data = array_map(function(CarChangeLog $log) {
            return $this->info($log);
        }, $logs);

        return $this->json($data);
    }

    #[Route('/driver/{id}', name: 'by_driver', methods: ['GET'])]
    public function byDriver(Driver $driver, CarChangeLogRepository $repository): JsonResponse
    {
        $logs = $repository->findBy(['driver' => $driver]);

        $data = array_map(function(CarChangeLog $log) {
            return $this->info($log);
        }, $logs);

        return $this->json($data);
    }

    #[Route('/car/{id}', name: 'by_car', methods: ['GET'])]
    public function byCar(Car $car, CarChangeLogRepository $repository): JsonResponse
    {
        $logs = $repository->findBy(['oldCar' => $car]);

        $data = array_map(function(CarChangeLog $log) {
            return $this->info($log);
        }, $logs);

        return $this->json($data);
    }
}
