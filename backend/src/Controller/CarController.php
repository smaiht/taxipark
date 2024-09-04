<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Driver;
use App\Repository\CarRepository;
use App\Repository\DriverRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[Route('/car', name: 'api_car_')]
class CarController extends AbstractController
{
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function list(CarRepository $carRepository): JsonResponse
    {
        $cars = $carRepository->findAll();
        
        $data = array_map(function(Car $car) {
            return $this->info($car);
        }, $cars);

        return $this->json($data);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(?Car $car): JsonResponse
    {
        if (!$car) {
            return $this->json(['error' => 'Car not found'], 404);
        }

        $data = $this->info($car);

        return $this->json($data);
    }

    private function info(Car $car): array|object
    {
        $data = [
            'id' => $car->getId(),
            'licensePlate' => $car->getLicensePlate(),
            'brand' => $car->getBrand(),
            'model' => ucfirst($car->getModel()),
            'drivers' => array_map(
                function($driver) {
                    return [
                        'id' => $driver->getId(),
                        'name' => $driver->getName(),
                    ];
                }, $car->getDrivers()->toArray()
            ),
        ];

        return $data;
    }

    #[Route('/do-create', name: 'create', methods: ['POST'])]
    #[Route('/{id}/do-edit', name: 'edit', methods: ['POST'])]
    public function editOrCreate(Request $request, EntityManagerInterface $entityManager, ?Car $car = null): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        if (!$car) {
            $car = new Car();
            $entityManager->persist($car);
        }
    
        $car->setLicensePlate($data['licensePlate']);
        $car->setBrand($data['brand']);
        $car->setModel($data['model']);
    
        $driverIds = array_column($data['drivers'], 'id');
        $drivers = $entityManager->getRepository(Driver::class)->findBy(['id' => $driverIds]);
        $car->setDrivers($drivers);
    
        $entityManager->flush();
    
        return $this->json([
            'success' => true,
            'id' => $car->getId(),
        ]);
    }
}
