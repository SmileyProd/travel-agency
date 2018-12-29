<?php

namespace App\Repository;

use App\Entity\Circuit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Circuit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Circuit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Circuit[]    findAll()
 * @method Circuit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CircuitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Circuit::class);
    }

//    /**
//     * @return Circuit[] Returns an array of Circuit objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Circuit
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findCircuits(Circuit $circuit) {
        $query = $this->createQueryBuilder('c');
        if($circuit->getId() != null) {
            $query->andWhere('c.id = :id');
        }
        if($circuit->getDescription() != null) {
            $query->andWhere('c.description = :description');
        }
        if($circuit->getDepartureCountry() != null) {
            $query->andWhere('c.departureCountry = :departureCountry');
        }
        if($circuit->getDepartureCity() != null) {
            $query->andWhere('c.departureCity = :departureCity');
        }
        if($circuit->getArrivalCity) {
            
        }
    }
}
