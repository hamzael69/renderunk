<?php

namespace App\Repository;

use App\Entity\Sportproduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sportproduct>
 *
 * @method Sportproduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sportproduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sportproduct[]    findAll()
 * @method Sportproduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SportproductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sportproduct::class);
    }

//    /**
//     * @return Sportproduct[] Returns an array of Sportproduct objects
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

//    public function findOneBySomeField($value): ?Sportproduct
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


/**
     * Retourne uniquement les liaisons avec un produit existant
     */
    public function findAllWithExistingProduct(): array
    {
        return $this->createQueryBuilder('sp')
            ->innerJoin('sp.product', 'p')
            ->addSelect('p')
            ->getQuery()
            ->getResult();
    }



}
