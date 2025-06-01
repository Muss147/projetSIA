<?php

namespace App\Repository;

use App\Entity\Utilitaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Utilitaires>
 */
class UtilitairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilitaires::class);
    }

       /**
        * @return Utilitaires[] Returns an array of Utilitaires objects
        */
       public function findByType($value): array
       {
           return $this->createQueryBuilder('u')
               ->andWhere('u.type = :val')
               ->setParameter('val', $value)
                ->andWhere('u.deletedAt IS NULL')
                ->orderBy('u.id', 'DESC')
            //    ->setMaxResults(10)
               ->getQuery()
               ->getResult()
           ;
       }

    //    public function findOneBySomeField($value): ?Utilitaires
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
