<?php

namespace App\Repository;

use App\Entity\Step;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Step|null find($id, $lockMode = null, $lockVersion = null)
 * @method Step|null findOneBy(array $criteria, array $orderBy = null)
 * @method Step[]    findAll()
 * @method Step[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StepRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Step::class);
    }

//    /**
//     * @return Step[] Returns an array of Step objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Step
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findOrderedStepsByCircuit($circuitId)
    {
        return $this->createQueryBuilder('s')
                    ->where('s.circuit=:id')
                    ->orderBy('s.stepNb', 'ASC')
                    ->setParameter('id', $circuitId)
                    ->getQuery()
                    ->getResult();
    }

    public function findAll() {
        return $this->createQueryBuilder('s')
                    ->orderBy('s.circuit')
                    ->addOrderBy('s.stepNb')
                    ->getQuery()
                    ->getResult();
    }
}
