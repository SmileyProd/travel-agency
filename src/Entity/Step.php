<?php

namespace App\Entity;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StepRepository")
 */
class Step implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\GreaterThan(0)
     */
    private $stepNb;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $city;

    /**
     * @ORM\Column(type="smallint")
     */
    private $nbDays;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Circuit", inversedBy="steps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $circuit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStepNb(): ?int
    {
        return $this->stepNb;
    }

    public function setStepNb(int $stepNb): self
    {
        $this->stepNb = $stepNb;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getNbDays(): ?int
    {
        return $this->nbDays;
    }

    public function setNbDays(int $nbDays): self
    {
        $this->nbDays = $nbDays;

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

    /**
     * Return a boolean. True if this step is the first Step of the circuit.
     */
    public function isFirstStep()
    {
        return $this->getStepNb() == 1;
    }

    /**
     * Return a boolean. True if this step is the last Step of the circuit.
     */
    public function isLastStep() {
        return $this->getStepNb() == $this->circuit->getNbSteps();
    }

    public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'stepNb' => $this->getStepNb(),
            'city' => $this->getCity(),
            'nbDays' => $this->getNbDays(),
            'circuit' => $this->getCircuit()->getId(),
        ];
    }
}
