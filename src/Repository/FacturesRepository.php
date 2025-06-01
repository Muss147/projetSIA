<?php

namespace App\Repository;

use App\Entity\Factures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Factures>
 */
class FacturesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Factures::class);
    }

       /**
        * @return Factures[] Returns an array of Factures objects
        */
       public function findAll(): array
       {
           return $this->createQueryBuilder('f')
                ->andWhere('f.deletedAt IS NULL')
                ->orderBy('f.id', 'ASC')
                ->getQuery()
                ->getResult()
           ;
       }

    //    public function findOneBySomeField($value): ?Factures
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
