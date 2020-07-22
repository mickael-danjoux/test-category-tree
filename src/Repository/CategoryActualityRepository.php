<?php

namespace App\Repository;

use App\Entity\CategoryActuality;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CategoryActuality|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryActuality|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryActuality[]    findAll()
 * @method CategoryActuality[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryActualityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryActuality::class);
    }

    // /**
    //  * @return CategoryActuality[] Returns an array of CategoryActuality objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategoryActuality
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
