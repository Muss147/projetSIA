<?php

namespace App\Repository;

use App\Entity\BPU;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BPU>
 */
class BPURepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BPU::class);
    }

       /**
        * @return BPU[] Returns an array of BPU objects
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

    //    public function findOneBySomeField($value): ?BPU
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
