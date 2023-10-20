<?php

namespace App\Repository;

use App\Entity\Expert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Expert>
 *
 * @method Expert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expert[]    findAll()
 * @method Expert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Expert::class);
    }

   /**
    * @return Expert[] Returns an array of Expert objects
    */
   public function findValidExperts(): array
   {
       return $this->createQueryBuilder('e')
            ->leftJoin('e.identity', 'i')
            ->andWhere('i.fileName <> :defaultAvatar') 
            ->setParameter('defaultAvatar', 'avatar-default.jpg')
            ->orderBy('e.id', 'ASC')
            ->getQuery()
            ->getResult()
       ;
   }


   /**
    * @return Experts[] Returns an array of Posting objects
    */
    public function findByQuery(string $query): array
    {
         if(empty($query)){
             return [];
         }
         
         $keywords = array_filter(explode(' ', $query));
         $parameters = [];
     
         $conditions = [];
         foreach ($keywords as $key => $keyword) {
             $conditions[] = '(e.title LIKE :query' . $key . 
                             ' OR e.mainSkills LIKE :query' . $key . 
                             ' OR u.firstName LIKE :query' . $key . 
                             ' OR u.lastName LIKE :query' . $key . 
                             ' OR e.aspiration LIKE :query' . $key . 
                             ' OR sec.name LIKE :query' . $key . ')';
             $parameters['query' . $key] = '%' . $keyword . '%';
         }
 
         $qb = $this->createQueryBuilder('e');
 
         $qb->select('e')
             ->leftJoin('e.sectors', 'sec')
             ->leftJoin('e.identity', 'ide')
             ->leftJoin('ide.user', 'u')
             ->andWhere(implode(' OR ', $conditions))
             ->setParameters($parameters)
             ->orderBy('e.id', 'ASC');
 
         return $qb->getQuery()->getResult();
 
    }

    /**
     * @return Expert[] Returns an array of Expert objects
     */
    public function findTopExperts(string $value = "", int $max = 10, int $offset = 0): array
    {
        return $this->createQueryBuilder('e')
             ->leftJoin('e.identity', 'i')
             ->andWhere('i.fileName <> :defaultAvatar') 
             ->setParameter('defaultAvatar', 'avatar-default.jpg')
             ->orderBy('e.id', 'ASC')
             ->setMaxResults($max)
             ->setFirstResult($offset)
             ->getQuery()
             ->getResult()
        ;
    }
}
