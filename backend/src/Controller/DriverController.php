<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\CarChangeLog;
use App\Entity\Driver;
use App\Repository\DriverRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/driver', name: 'api_driver_')]
class DriverController extends AbstractController
{
    // #[Route('/driver')]
    // public function index(): Response
    // {
    //     return $this->render('driver/index.html.twig', [
    //         'controller_name' => 'DriverController',
    //     ]);
    // }

    // #[Route('/driver-api')]
    // public function createDriver(): JsonResponse
    // {
    //     return $this->json([
    //         'message' => 'test',
    //     ]);
    // }


    #[Route('/list', name: 'list', methods: ['GET'])]
    public function list(DriverRepository $driverRepository): JsonResponse
    {
        $drivers = $driverRepository->findAll();
        
        $data = array_map(function(Driver $driver) {
            return $this->info($driver);
        }, $drivers);

        return $this->json($data);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(?Driver $driver): JsonResponse
    {
        if (!$driver) {
            return $this->json(['error' => 'Driver not found'], 404);
        }

        $data = $this->info($driver);

        return $this->json($data);
    }

    private function info(Driver $driver): array|object
    {
        $today = new \DateTime();

        $car = $driver->getCar();
        $data = [
            'id' => $driver->getId(),
            'name' => $driver->getName(),
            'birthday' => $driver->getBirthday()->format('Y-m-d'),
            'age' => $today->diff($driver->getBirthday())->y,
            'car' => $car ? [
                'id' => $car->getId(),
                'licensePlate' => $car->getLicensePlate(),
                'brand' => $car->getBrand(),
                'model' => ucfirst($car->getModel()),
            ] : null,
        ];

        return $data;
    }

    #[Route('/do-create', name: 'create', methods: ['POST'])]
    #[Route('/{id}/do-edit', name: 'edit', methods: ['POST'])]
    public function editOrCreate(Request $request, ?Driver $driver = null, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$driver) {
            $driver = new Driver();
            $entityManager->persist($driver);
        }

        $driver->setName($data['name']);
        $driver->setBirthday(new \DateTime($data['birthday']));
    
        $oldCar = $driver->getCar();
        $newCar = $data['car'] ? $entityManager->find(Car::class, $data['car']['id']) : null;

        if ($oldCar !== $newCar) {
            $log = new CarChangeLog();
            $log->setChangeDate(new \DateTime());
            $log->setOldCar($oldCar);
            $log->setNewCar($newCar);
            $log->setDriver($driver);
            $entityManager->persist($log);
        }

        $driver->setCar($newCar);
    
        $entityManager->flush();

        return $this->json([
            'success' => true,
            'id' => $driver->getId(),
        ]);
    }
}
