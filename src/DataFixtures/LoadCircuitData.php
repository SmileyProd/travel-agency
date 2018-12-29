<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Circuit;

class LoadCircuitData extends Fixture
{
	public function load(ObjectManager $manager)
	{		
		$category = $this->getReference('repos-category');

		$circuit = new Circuit();
		$circuit->setDescription('Andalousie');
		$circuit->setDepartureCountry('Espagne');
		$circuit->setCategory($category);
		$manager->persist($circuit);
		
		$this->addReference('andalousie-circuit', $circuit);
		
		$category = $this->getReference('budget-category');

		$circuit = new Circuit();
		$circuit->setDescription('Vietnam');
		$circuit->setDepartureCountry('VietNam');
		$circuit->setCategory($category);
		$manager->persist($circuit);
		
		$this->addReference('vietnam-circuit', $circuit);
		
		$category = $this->getReference('famille-category');

		$circuit = new Circuit();
		$circuit->setDescription('Ile de France');
		$circuit->setDepartureCountry('France');
		$circuit->setCategory($category);
		$manager->persist($circuit);
		
		$this->addReference('idf-circuit', $circuit);
		
		$category = $this->getReference('gastronomie-category');

		$circuit = new Circuit();
		$circuit->setDescription('Italie');
		$circuit->setDepartureCountry('Italie');
		$circuit->setCategory($category);
		$manager->persist($circuit);
		
		$this->addReference('italie-circuit', $circuit);
		
		$manager->flush();
	}
	
}
// (1, 'Andalousie', 'Espagne', 'repos'),
// (2, 'VietNam', 'VietNam', 'budget'),
// (3, 'Ile de France', 'France', 'famille),
// (4, 'Italie', 'Italie', 'solo);