<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Step;

class LoadStepData extends Fixture implements DependentFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$circuit=$this->getReference('andalousie-circuit');
		
		$step = new Step();
		$step->setStepNb(1);
		$step->setCity("Grenade");
		$step->setNbDays(3);
		$circuit->addStep($step);
		$manager->persist($step);
		
		$step = new Step();
		$step->setStepNb(2);
		$step->setCity("Cordoue");
		$step->setNbDays(2);
		$circuit->addStep($step);
		$manager->persist($step);
		
		$step = new Step();
		$step->setStepNb(3);
		$step->setCity("Séville");
		$step->setNbDays(4);
		$circuit->addStep($step);
		$manager->persist($step);

		$circuit->setDepartureCity('Grenade');
		$circuit->setArrivalCity('Séville');
		$circuit->updateDuration();
		
		$circuit=$this->getReference('vietnam-circuit');
		
		$step = new Step();
		$step->setStepNb(1);
		$step->setCity("Hanoï");
		$step->setNbDays(5);
		$circuit->addStep($step);
		$manager->persist($step);
		
		
		$step = new Step();
		$step->setStepNb(3);
		$step->setCity("Hôi An");
		$step->setNbDays(2);
		$circuit->addStep($step);
		$manager->persist($step);
		
		$step = new Step();
		$step->setStepNb(4);
		$step->setCity("Hô Chi Minh");
		$step->setNbDays(4);
		$circuit->addStep($step);
		$manager->persist($step);
		
		$step = new step();
		$step->setStepNb(2);
		$step->setCity("Dà Nang");
		$step->setNbDays(1);
		$circuit->addStep($step);
		$manager->persist($step);
		

		$circuit->setDepartureCity('Hanoï');
		$circuit->setArrivalCity('Hô Chi Minh');
		$circuit->updateDuration();
		
		$circuit=$this->getReference('idf-circuit');
		
		$step = new Step();
		$step->setStepNb(1);
		$step->setCity("Versailles");
		$step->setNbDays(3);
		$circuit->addStep($step);
		$manager->persist($step);
		
		$step = new Step();
		$step->setStepNb(2);
		$step->setCity("Paris");
		$step->setNbDays(6);
		$circuit->addStep($step);
		$manager->persist($step);
		
		$circuit->setDepartureCity('Versailles');
		$circuit->setArrivalCity('Paris');
		$circuit->updateDuration();
		
		$circuit=$this->getReference('italie-circuit');
		
		$step = new Step();
		$step->setStepNb(1);
		$step->setCity("Florence");
		$step->setNbDays(4);
		$circuit->addStep($step);
		$manager->persist($step);
		
		$step = new Step();
		$step->setStepNb(2);
		$step->setCity("Sienne");
		$step->setNbDays(2);
		$circuit->addStep($step);
		$manager->persist($step);
		
		$step = new Step();
		$step->setStepNb(3);
		$step->setCity("Pise");
		$step->setNbDays(6);
		$circuit->addStep($step);
		$manager->persist($step);
		
		$step = new Step();
		$step->setStepNb(4);
		$step->setCity("Rome");
		$step->setNbDays(3);
		$circuit->addStep($step);
		$manager->persist($step);
		
		$circuit->setDepartureCity('Florence');
		$circuit->setArrivalCity('Rome');
		$circuit->updateDuration();
		
		$manager->flush();
	}

	public function getDependencies()
	{
	    return array(
	        LoadCircuitData::class,
	    );
	}
}