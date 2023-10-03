<?php

namespace App\Repository\Type;

use App\Entity\Type\PostingType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PostingType>
 *
 * @method PostingType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostingType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostingType[]    findAll()
 * @method PostingType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostingTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostingType::class);
    }

//    /**
//     * @return PostingType[] Returns an array of PostingType objects
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

//    public function findOneBySomeField($value): ?PostingType
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
