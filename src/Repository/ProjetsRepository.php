<?php

namespace App\Repository;

use App\Entity\Projets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Projets>
 */
class ProjetsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projets::class);
    }

       /**
        * @return Projets[] Returns an array of Projets objects
        */
       public function findAll(): array
       {
           return $this->createQueryBuilder('p')
                ->andWhere('p.deletedAt IS NULL')
                ->orderBy('p.id', 'ASC')
                ->getQuery()
                ->getResult()
           ;
       }

    //    public function findOneBySomeField($value): ?Projets
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
