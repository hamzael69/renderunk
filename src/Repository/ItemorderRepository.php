<?php

namespace App\Repository;

use App\Entity\Itemorder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Itemorder>
 *
 * @method Itemorder|null find($id, $lockMode = null, $lockVersion = null)
 * @method Itemorder|null findOneBy(array $criteria, array $orderBy = null)
 * @method Itemorder[]    findAll()
 * @method Itemorder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemorderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Itemorder::class);
    }

//    /**
//     * @return Itemorder[] Returns an array of Itemorder objects
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

//    public function findOneBySomeField($value): ?Itemorder
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
