<?php

namespace App\Repository\Note;

use App\Entity\Note\SkillNote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SkillNote>
 *
 * @method SkillNote|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillNote|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillNote[]    findAll()
 * @method SkillNote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillNoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillNote::class);
    }

//    /**
//     * @return SkillNote[] Returns an array of SkillNote objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SkillNote
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
