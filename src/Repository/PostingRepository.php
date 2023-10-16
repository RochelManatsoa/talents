<?php

namespace App\Repository;

use App\Entity\Posting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Posting>
 *
 * @method Posting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Posting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Posting[]    findAll()
 * @method Posting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Posting::class);
    }

   /**
    * @return Posting[] Returns an array of Posting objects
    */
   public function findValid(): array
   {
       return $this->createQueryBuilder('p')
       ->andWhere('p.isValid = 1')
       ->andWhere('p.status = :status')
       ->setParameter('status', Posting::STATUS_PUBLISHED)
       ->orderBy('p.id', 'ASC')
       ->getQuery()
       ->getResult()
       ;
   }

   /**
    * @return Postings[] Returns an array of Posting objects
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
            $conditions[] = '(p.title LIKE :query' . $key . 
                            ' OR p.description LIKE :query' . $key . 
                            ' OR sec.name LIKE :query' . $key . 
                            ' OR lang.name LIKE :query' . $key . 
                            ' OR ts.name LIKE :query' . $key . ')';
            $parameters['query' . $key] = '%' . $keyword . '%';
        }

        $qb = $this->createQueryBuilder('p');

        $qb->select('p')
            ->leftJoin('p.sector', 'sec')
            ->leftJoin('p.technicalSkills', 'ts')
            ->leftJoin('p.languages', 'lang')
            ->andWhere('p.isValid = 1')
            ->andWhere('p.status = :status')
            ->andWhere(implode(' OR ', $conditions))
            ->setParameters(array_merge(['status' => Posting::STATUS_PUBLISHED], $parameters))
            ->orderBy('p.id', 'ASC');

        return $qb->getQuery()->getResult();

        // return $this->createQueryBuilder('p')
        //     ->andWhere('p.isValid = 1')
        //     ->andWhere('p.status = :status')
        //     ->andWhere('p.title LIKE :query OR p.description LIKE :query') // Je suppose que vous voulez rechercher dans 'title' et 'description'
        //     ->setParameter('status', Posting::STATUS_PUBLISHED)
        //     ->setParameter('query', '%'. $query .'%')
        //     ->orderBy('p.id', 'ASC')
        //     ->getQuery()
        //     ->getResult()
        // ;
   }

//    public function findOneBySomeField($value): ?Posting
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
