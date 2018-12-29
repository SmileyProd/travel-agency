<?php

namespace App\Repository;

use App\Entity\CircuitProgram;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CircuitProgram|null find($id, $lockMode = null, $lockVersion = null)
 * @method CircuitProgram|null findOneBy(array $criteria, array $orderBy = null)
 * @method CircuitProgram[]    findAll()
 * @method CircuitProgram[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CircuitProgramRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CircuitProgram::class);
    }

//    /**
//     * @return CircuitProgram[] Returns an array of CircuitProgram objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CircuitProgram
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAll() {
        return $this->createQueryBuilder('p')
                    ->orderBy('p.circuit')
                    ->addOrderBy('p.id')
                    ->addOrderBy('p.departureDate')
                    ->getQuery()
                    ->getResult();
    }

    public function findAllValidPrograms() {
        return $this->createQueryBuilder('p')
                    ->where('p.departureDate > :now')
                    ->setParameter('now', new \Datetime())
                    ->orderBy('p.circuit')
                    ->addOrderBy('p.id')
                    ->addOrderBy('p.departureDate', 'ASC')
                    ->getQuery()
                    ->getResult();
    }

    public function findAllValidProgramsOrderedByDate() {
        return $this->createQueryBuilder('p')
                    ->where('p.departureDate > :now')
                    ->setParameter('now', new \Datetime())
                    ->addOrderBy('p.departureDate')
                    ->getQuery()
                    ->getResult();
    }

    public function findValidProgramsByCircuit($idCircuit) {
        return $this->createQueryBuilder('p')
                    ->where('p.departureDate > :now')
                    ->andWhere('p.circuit = :id')
                    ->setParameter('id', $idCircuit)
                    ->setParameter('now', new \Datetime())
                    ->orderBy('p.departureDate')
                    ->addOrderBy('p.id')
                    ->getQuery()
                    ->getResult();
    }

    public function findAllInvalidPrograms() {
        return $this->createQueryBuilder('p')
                    ->where('p.departureDate < :now')
                    ->setParameter('now', new \Datetime())
                    ->orderBy('p.circuit')
                    ->addOrderBy('p.id')
                    ->getQuery()
                    ->getResult();
    }
}
