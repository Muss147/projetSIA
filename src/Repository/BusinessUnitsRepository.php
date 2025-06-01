<?php

namespace App\Repository;

use App\Entity\BusinessUnits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BusinessUnits>
 */
class BusinessUnitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BusinessUnits::class);
    }

       /**
        * @return BusinessUnits[] Returns an array of BusinessUnits objects
        */
       public function findAll(): array
       {
           return $this->createQueryBuilder('b')
                ->andWhere('b.deletedAt IS NULL')
                ->orderBy('b.id', 'ASC')
                ->getQuery()
                ->getResult()
           ;
       }

    //    public function findOneBySomeField($value): ?BusinessUnits
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
