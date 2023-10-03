<?php

namespace App\Repository\Views;

use App\Entity\Views\PostingViews;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PostingViews>
 *
 * @method PostingViews|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostingViews|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostingViews[]    findAll()
 * @method PostingViews[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostingViewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostingViews::class);
    }

//    /**
//     * @return PostingViews[] Returns an array of PostingViews objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PostingViews
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
