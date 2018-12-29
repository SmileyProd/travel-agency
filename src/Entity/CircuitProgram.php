<?php

namespace App\Entity;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CircuitProgramRepository")
 */
class CircuitProgram implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $departureDate;

    /**
     * @ORM\Column(type="smallint")
     */
    private $nbPeople;

    /**
     * @ORM\Column(type="smallint")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Circuit", inversedBy="programs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $circuit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departureDate;
    }

    public function setDepartureDate(\DateTimeInterface $departureDate): self
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    public function getNbPeople(): ?int
    {
        return $this->nbPeople;
    }

    public function setNbPeople(int $nbPeople): self
    {
        $this->nbPeople = $nbPeople;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCircuit(): ?Circuit
    {
        return $this->circuit;
    }

    public function setCircuit(?Circuit $circuit): self
    {
        $this->circuit = $circuit;

        return $this;
    }

    public function jsonSerialize(){
        return [
            'id' => $this->getId(),
            'departureDate' => $this->getDepartureDate(),
            'nbPeople' => $this->getNbPeople(),
            'price' => $this->getPrice(),
            'circuit' => $this->getCircuit()->getId(),
        ];
    }
}
