<?php

namespace App\Repository;

use App\Entity\CircuitCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CircuitCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method CircuitCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method CircuitCategory[]    findAll()
 * @method CircuitCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CircuitCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CircuitCategory::class);
    }

    // /**
    //  * @return CircuitCategory[] Returns an array of CircuitCategory objects
    //  */
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
    public function findOneBySomeField($value): ?CircuitCategory
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
