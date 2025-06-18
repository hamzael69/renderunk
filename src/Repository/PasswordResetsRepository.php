<?php

namespace App\Repository;

use App\Entity\PasswordResets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PasswordResets>
 *
 * @method PasswordResets|null find($id, $lockMode = null, $lockVersion = null)
 * @method PasswordResets|null findOneBy(array $criteria, array $orderBy = null)
 * @method PasswordResets[]    findAll()
 * @method PasswordResets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PasswordResetsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PasswordResets::class);
    }

//    /**
//     * @return PasswordResets[] Returns an array of PasswordResets objects
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

//    public function findOneBySomeField($value): ?PasswordResets
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
