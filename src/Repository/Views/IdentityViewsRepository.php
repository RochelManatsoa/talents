<?php

namespace App\Repository\Views;

use App\Entity\Views\IdentityViews;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IdentityViews>
 *
 * @method IdentityViews|null find($id, $lockMode = null, $lockVersion = null)
 * @method IdentityViews|null findOneBy(array $criteria, array $orderBy = null)
 * @method IdentityViews[]    findAll()
 * @method IdentityViews[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdentityViewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IdentityViews::class);
    }

//    /**
//     * @return IdentityViews[] Returns an array of IdentityViews objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?IdentityViews
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
