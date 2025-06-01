<?php

namespace App\Repository;

use App\Entity\Contrats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contrats>
 */
class ContratsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contrats::class);
    }

       /**
        * @return Contrats[] Returns an array of Contrats objects
        */
       public function findAll(): array
       {
           return $this->createQueryBuilder('c')
                ->andWhere('c.deletedAt IS NULL')
                ->orderBy('c.id', 'ASC')
                ->getQuery()
                ->getResult()
           ;
       }

    //    public function findOneBySomeField($value): ?Contrats
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
