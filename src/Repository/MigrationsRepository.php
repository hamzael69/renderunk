<?php

namespace App\Repository;

use App\Entity\Migrations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Migrations>
 *
 * @method Migrations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Migrations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Migrations[]    findAll()
 * @method Migrations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MigrationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Migrations::class);
    }

//    /**
//     * @return Migrations[] Returns an array of Migrations objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Migrations
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
