<?php

namespace App\DataFixtures;

use App\Entity\CircuitCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCategoryData extends Fixture
{
	public function load(ObjectManager $manager)
	{		
		$category = new CircuitCategory();
		$category->setName('Budget');
		$manager->persist($category);
		
		$this->addReference('budget-category', $category);
		
        $category = new CircuitCategory();
		$category->setName('Solo');
		$manager->persist($category);
		
        $this->addReference('solo-category', $category);
        
        $category = new CircuitCategory();
		$category->setName('Famille');
		$manager->persist($category);
		
        $this->addReference('famille-category', $category);
        
        $category = new CircuitCategory();
		$category->setName('Aventure');
		$manager->persist($category);
		
        $this->addReference('aventure-category', $category);
        
        $category = new CircuitCategory();
		$category->setName('Gastronomie');
		$manager->persist($category);
		
        $this->addReference('gastronomie-category', $category);

        $category = new CircuitCategory();
		$category->setName('Repos');
		$manager->persist($category);
		
        $this->addReference('repos-category', $category);

        $manager->flush();
	}
	
}
// (1, 'budget'),
// (2, 'solo'),
// (3, 'famille'),
// (4, 'aventure'),
// (5, 'gastronomie'),
// (6, 'repos');