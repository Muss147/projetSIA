<?php

namespace App\Repository;

use App\Entity\Clients;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Clients>
 */
class ClientsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Clients::class);
    }

       /**
        * @return Clients[] Returns an array of Clients objects
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

    //    public function findOneBySomeField($value): ?Clients
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
