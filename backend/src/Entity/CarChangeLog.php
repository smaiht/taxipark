<?php

namespace App\Entity;

use App\Repository\CarChangeLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarChangeLogRepository::class)]
class CarChangeLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $changeDate = null;

    #[ORM\ManyToOne]
    private ?Car $oldCar = null;

    #[ORM\ManyToOne]
    private ?Car $newCar = null;

    #[ORM\ManyToOne(inversedBy: 'carChangeLogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Driver $driver = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChangeDate(): ?\DateTimeInterface
    {
        return $this->changeDate;
    }

    public function setChangeDate(\DateTimeInterface $changeDate): static
    {
        $this->changeDate = $changeDate;

        return $this;
    }

    public function getOldCar(): ?Car
    {
        return $this->oldCar;
    }

    public function setOldCar(?Car $oldCar): static
    {
        $this->oldCar = $oldCar;

        return $this;
    }

    public function getNewCar(): ?Car
    {
        return $this->newCar;
    }

    public function setNewCar(?Car $newCar): static
    {
        $this->newCar = $newCar;

        return $this;
    }

    public function getDriver(): ?Driver
    {
        return $this->driver;
    }

    public function setDriver(?Driver $driver): static
    {
        $this->driver = $driver;

        return $this;
    }
}
