<?php

namespace App\Repository;

use App\Entity\Collar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Collar>
 *
 * @method Collar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collar[]    findAll()
 * @method Collar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Collar::class);
    }

//    /**
//     * @return Collar[] Returns an array of Collar objects
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

//    public function findOneBySomeField($value): ?Collar
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
