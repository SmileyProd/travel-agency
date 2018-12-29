<?php

namespace App\Entity;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CircuitRepository")
 */
class Circuit implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $departureCountry;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $departureCity;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $arrivalCity;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $duration;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Step", mappedBy="circuit", orphanRemoval=true)
     */
    private $steps;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CircuitProgram", mappedBy="circuit", orphanRemoval=true)
     */
    private $programs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CircuitCategory", inversedBy="circuits")
     */
    private $category;

    public function __construct()
    {
        $this->steps = new ArrayCollection();
        $this->programs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDepartureCountry(): ?string
    {
        return $this->departureCountry;
    }

    public function setDepartureCountry(?string $departureCountry): self
    {
        $this->departureCountry = $departureCountry;

        return $this;
    }

    public function getDepartureCity(): ?string
    {
        return $this->departureCity;
    }

    public function setDepartureCity(?string $departureCity): self
    {
        $this->departureCity = $departureCity;

        return $this;
    }

    public function getArrivalCity(): ?string
    {
        return $this->arrivalCity;
    }

    public function setArrivalCity(?string $arrivalCity): self
    {
        $this->arrivalCity = $arrivalCity;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection|Step[]
     */
    public function getSteps(): Collection
    {
        return $this->steps;
    }

    public function addStep(Step $step): self
    {
        if (!$this->steps->contains($step)) {
            $this->steps[] = $step;
            $step->setCircuit($this);
        }

        return $this;
    }

    public function removeStep(Step $step): self
    {
        if ($this->steps->contains($step)) {
            $this->steps->removeElement($step);
            // set the owning side to null (unless already changed)
            if ($step->getCircuit() === $this) {
                $step->setCircuit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CircuitProgram[]
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(CircuitProgram $program): self
    {
        if (!$this->programs->contains($program)) {
            $this->programs[] = $program;
            $program->setCircuit($this);
        }

        return $this;
    }

    public function removeProgram(CircuitProgram $program): self
    {
        if ($this->programs->contains($program)) {
            $this->programs->removeElement($program);
            // set the owning side to null (unless already changed)
            if ($program->getCircuit() === $this) {
                $program->setCircuit(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return (string) $this->getId();
    }

    public function updateDuration() {
        $newDuration = 0;
        foreach($this->getSteps() as $step) {
            $newDuration += $step->getNbDays();
        }
        $this->setDuration($newDuration);
    }

    public function getValidPrograms()
    {
        $validPrograms = array();
        $date = new \DateTime();
        foreach($this->programs as $program) {
            if($program->getDepartureDate() > $date){
                $validPrograms[] = $program;
            }
        }
        if(count($validPrograms) > 0) {
            return $validPrograms;
        }
        else return null;
    }

    /**
     * When a step is inserted, edited, or deleted, the number of the steps change so we need to update the step order.
     * 
     * To do that, we need to know by the parameter action what happened: insert, edit, delete
     * To make easy our job we get all the steps ordered by their StepNb.
     * We also get the step updated.
     * 
     * When a step is edited it changes the order of the steps differently if the new number of the step is inferior or       superior of the ancient number.
     */
    public function updateStepsAndCities($orderedSteps, $stepUpdated, $action) {
        $nbSteps = $this->getNbSteps();
        switch($action) { 
            case 'insert':
                for($i = $stepUpdated->getStepNb() - 1; $i < $nbSteps; $i++){
                    $orderedSteps[$i]->setStepNb($i + 2); 
                }

                // Update departure and arrival city
                if($nbSteps == 0) {
                    $this->setDepartureCity($stepUpdated->getCity());
                    $this->setArrivalCity($stepUpdated->getCity());
                }
                else {
                    if($stepUpdated->isFirstStep()){
                        $this->setDepartureCity($stepUpdated->getCity());
                    }
                    elseif($stepUpdated->getStepNb() == ($nbSteps + 1)) {
                        $this->setArrivalCity($stepUpdated->getCity());
                    }
                }

                $this->setDuration($this->getDuration() + $stepUpdated->getNbDays());

            break;

            case 'edit':
                for($i = 0; $i < $nbSteps; $i++) {
                    if($orderedSteps[$i]->getId() == $stepUpdated->getId()) {
                        $previousNbStep = $i + 1;
                    }
                }

                if($previousNbStep > $stepUpdated->getStepNb()) {
                    for($i = $stepUpdated->getStepNb() - 1; $i < $previousNbStep - 1; $i++) {
                        $orderedSteps[$i]->setStepNb($i + 2);
                    }
                }
                else if ($previousNbStep < $stepUpdated->getStepNb()) {
                    for($i = $previousNbStep; $i < $stepUpdated->getStepNb(); $i++) {
                        $orderedSteps[$i]->setStepNb($i);
                    }
                }

                // Update departure and arrival city
                if($nbSteps == 1) {
                    $this->setDepartureCity($stepUpdated->getCity());
                    $this->setArrivalCity($stepUpdated->getCity());
                }
                else {
                    if ($stepUpdated->isFirstStep()){
                        $this->setDepartureCity($stepUpdated->getCity());
                    }
                    elseif($previousNbStep == 1) {
                        $this->setDepartureCity($orderedSteps[1]->getCity());
                    }
                    if($stepUpdated->isLastStep()) {
                        $this->setArrivalCity($stepUpdated->getCity());
                    }
                    elseif($previousNbStep == $nbSteps) {
                        $this->setArrivalCity($orderedSteps[$nbSteps-2]->getCity());
                    }
                }

                $this->updateDuration();

            break;
            
            case 'delete':
                for($i = $stepUpdated->getStepNb(); $i < $nbSteps; $i++){
                    $orderedSteps[$i]->setStepNb($i); 
                }

                // Update departure and arrival city
                if($nbSteps == 1) {
                    $this->setDepartureCity("");
                    $this->setArrivalCity("");
                }
                else{
                    if($stepUpdated->isFirstStep()){
                        $this->setDepartureCity($orderedSteps[1]->getCity());
                    }
                    elseif($stepUpdated->isLastStep()) {
                        $this->setArrivalCity($orderedSteps[$nbSteps-2]->getCity());
                    }
                }

                $this->setDuration($this->getDuration() - $stepUpdated->getNbDays());

                break;
            
            default:
                echo 'Erreur dans le switch méthode UpdateStepOrder';
            break;

            foreach($this->getSteps() as $step) {

            }
        }
    }
    
    /**
     * Get the number of steps
     */
    public function getNbSteps() {
        return count($this->getSteps());
    }

    /**
     * Order the steps
     */
    public function orderSteps() {
        for($i = count($this->steps) - 2;$i >= 0; $i--) {
            for($j = 0; $j <= $i; $j++) {
                if($this->steps[$j + 1]->getStepNb() < $this->steps[$j]->getStepNb()) {
                    $t = $this->steps[$j + 1]->getStepNb();
                    $this->steps[$j + 1]->setStepNb($this->steps[$j]->getStepNb());
                    $this->steps[$j]->setStepNb($t);
                }
            }
        }   
    }

    /**
     * Order the programs
     */
    public function orderPrograms() {
        for($i = count($this->programs) - 2;$i >= 0; $i--) {
            for($j = 0; $j <= $i; $j++) {
                if($this->programs[$j + 1]->getDepartureDate() < $this->programs[$j]->getDepartureDate()) {
                    $t = $this->programs[$j + 1]->getDepartureDate();
                    $this->programs[$j + 1]->setDepartureDate($this->programs[$j]->getDepartureDate());
                    $this->programs[$j]->setDepartureDate($t);
                }
            }
        }   
    }

    /**
     * Return array representing the circuit
     */
    public function jsonSerialize() {
        $this->orderSteps();
        $this->orderPrograms();
        $steps = [];
        foreach($this->getSteps() as $step) {
            $steps[] = $step->jsonSerialize();
        }

        $programs = [];
        foreach($this->getPrograms() as $program) {
            $programs[] = $program->jsonSerialize();
        }

        return [
            'id' => $this->getId(),
            'description' => $this->getDescription(),
            'departureCountry' => $this->getDepartureCountry(),
            'departureCity' => $this->getDepartureCity(),
            'arrivalCity' => $this->getArrivalCity(),
            'duration' => $this->getDuration(),
            'category' => $this->getCategory() ? $this->getCategory()->getName() : "",
            'steps' => $steps,
            'programs' => $programs,
        ];
    }

    public function getCategory(): ?CircuitCategory
    {
        return $this->category;
    }

    public function setCategory(?CircuitCategory $category): self
    {
        $this->category = $category;

        return $this;
    }
}
