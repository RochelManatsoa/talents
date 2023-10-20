<?php

namespace App\Repository;

use App\Entity\Identity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Identity>
 *
 * @method Identity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Identity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Identity[]    findAll()
 * @method Identity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdentityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Identity::class);
    }

    /**
    * @return Identity[] Returns an array of Identity objects
    */
   public function findSearch(int $max = 12, int $offset = null): array
   {
        $query = $this->createQueryBuilder('i')
            ->select('i, COUNT(v.id) as HIDDEN num_views')
            // ->join('i.sectors', 's')
            // ->join('i.aicores', 'a')
            // ->join('i.languages', 'la')
            // ->join('la.lang', 'l')
            ->leftJoin('i.views', 'v')
            ->andWhere('i.fileName <> :defaultAvatar')
            ->andWhere('i.username IS NOT NULL')
            ->setParameter('defaultAvatar', 'avatar-default.jpg')
            ->groupBy('i.id')
            ->orderBy('num_views', 'DESC')
            ->setMaxResults($max)
            ->setFirstResult($offset)
        ;
        return $query->getQuery()->getResult();
   }

   public function findTopRanked() : array
   {
        return $this->createQueryBuilder('i')
            ->select('i, COUNT(v.id) as HIDDEN num_views')
            ->leftJoin('i.views', 'v')  
            ->groupBy('i')
            ->orderBy('num_views', 'DESC') 
            ->setMaxResults(12)
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return Identity[] Returns an array of Identity objects
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

//    public function findOneBySomeField($value): ?Identity
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
