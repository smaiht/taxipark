<?php

namespace App\Entity;

use App\Repository\DriverRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DriverRepository::class)]
class Driver
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\ManyToOne(inversedBy: 'drivers')]
    private ?Car $car = null;

    /**
     * @var Collection<int, CarChangeLog>
     */
    #[ORM\OneToMany(targetEntity: CarChangeLog::class, mappedBy: 'driver', orphanRemoval: true)]
    private Collection $carChangeLogs;

    public function __construct()
    {
        $this->carChangeLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): static
    {
        $this->car = $car;

        return $this;
    }

    /**
     * @return Collection<int, CarChangeLog>
     */
    public function getCarChangeLogs(): Collection
    {
        return $this->carChangeLogs;
    }

    public function addCarChangeLog(CarChangeLog $carChangeLog): static
    {
        if (!$this->carChangeLogs->contains($carChangeLog)) {
            $this->carChangeLogs->add($carChangeLog);
            $carChangeLog->setDriver($this);
        }

        return $this;
    }

    public function removeCarChangeLog(CarChangeLog $carChangeLog): static
    {
        if ($this->carChangeLogs->removeElement($carChangeLog)) {
            // set the owning side to null (unless already changed)
            if ($carChangeLog->getDriver() === $this) {
                $carChangeLog->setDriver(null);
            }
        }

        return $this;
    }
}
