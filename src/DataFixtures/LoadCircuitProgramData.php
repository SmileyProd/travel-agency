<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Circuit;
use App\Entity\CircuitProgram;

class LoadCircuitProgramData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $andalousieCircuit = $this->getReference('andalousie-circuit');
        $andalousieProgram = new CircuitProgram();
        $andalousieProgram->setDepartureDate(new \DateTime("2021-07-08 0:0:0.0"))
                          ->setNbPeople(7)
                          ->setPrice(7000)
                          ->setCircuit($andalousieCircuit);
        $manager->persist($andalousieProgram);
        $this->addReference('andalousie1-program', $andalousieProgram);

        $andalousieProgram = new CircuitProgram();
        $andalousieProgram->setDepartureDate(new \DateTime("2017-05-30 0:0:0.0"))
                          ->setNbPeople(4)
                          ->setPrice(3500)
                          ->setCircuit($andalousieCircuit);
        $manager->persist($andalousieProgram);
        $this->addReference('andalousie2-program', $andalousieProgram);

        $andalousieProgram = new CircuitProgram();
        $andalousieProgram->setDepartureDate(new \DateTime("2019-03-04 0:0:0.0"))
                          ->setNbPeople(12)
                          ->setPrice(8500)
                          ->setCircuit($andalousieCircuit);
        $manager->persist($andalousieProgram);
        $this->addReference('andalousie3-program', $andalousieProgram);

        $vietnamCircuit = $this->getReference('vietnam-circuit');
        $vietnamProgram = new CircuitProgram();
        $vietnamProgram->setDepartureDate(new \DateTime("2020-07-08 0:0:0.0"))
                       ->setNbPeople(15)
                       ->setPrice(10000)
                       ->setCircuit($vietnamCircuit);
        $manager->persist($vietnamProgram);
        $this->addReference('vietnam1-program', $vietnamProgram);

        $vietnamProgram = new CircuitProgram();
        $vietnamProgram->setDepartureDate(new \DateTime("2018-09-25 0:0:0.0"))
                       ->setNbPeople(9)
                       ->setPrice(7650)
                       ->setCircuit($vietnamCircuit);
        $manager->persist($vietnamProgram);
        $this->addReference('vietnam2-program', $vietnamProgram);

        $vietnamProgram = new CircuitProgram();
        $vietnamProgram->setDepartureDate(new \DateTime("2017-03-08 0:0:0.0"))
                       ->setNbPeople(4)
                       ->setPrice(2800)
                       ->setCircuit($vietnamCircuit);
        $manager->persist($vietnamProgram);
        $this->addReference('vietnam3-program', $vietnamProgram);

        $idfCircuit = $this->getReference('idf-circuit');
        $idfProgram = new CircuitProgram();
        $idfProgram->setDepartureDate(new \DateTime("2017-01-02 0:0:0.0"))
                       ->setNbPeople(2)
                       ->setPrice(4000)
                       ->setCircuit($idfCircuit);
        $manager->persist($idfProgram);
        $this->addReference('idf-program', $idfProgram);

        $italieCircuit = $this->getReference('italie-circuit');
        $italieProgram = new CircuitProgram();
        $italieProgram->setDepartureDate(new \DateTime("2015-01-24 0:0:0.0"))
                       ->setNbPeople(2)
                       ->setPrice(6000)
                       ->setCircuit($italieCircuit);
        $manager->persist($italieProgram);
        $this->addReference('italie1-program', $italieProgram);

        $italieProgram = new CircuitProgram();
        $italieProgram->setDepartureDate(new \DateTime("2018-11-22 0:0:0.0"))
                       ->setNbPeople(2)
                       ->setPrice(4500)
                       ->setCircuit($italieCircuit);
        $manager->persist($italieProgram);
        $this->addReference('italie2-program', $italieProgram);

        $italieProgram = new CircuitProgram();
        $italieProgram->setDepartureDate(new \DateTime("2018-12-29 0:0:0.0"))
                       ->setNbPeople(4)
                       ->setPrice(6200)
                       ->setCircuit($italieCircuit);
        $manager->persist($italieProgram);
        $this->addReference('italie3-program', $italieProgram);

        $manager->flush();
    }

    public function getDependencies()
	{
	    return array(
	        LoadCircuitData::class,
	    );
	}
}
