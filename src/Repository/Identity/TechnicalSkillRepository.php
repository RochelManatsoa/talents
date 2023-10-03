<?php

namespace App\Repository\Identity;

use App\Entity\Identity\TechnicalSkill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TechnicalSkill>
 *
 * @method TechnicalSkill|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechnicalSkill|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechnicalSkill[]    findAll()
 * @method TechnicalSkill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechnicalSkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechnicalSkill::class);
    }

//    /**
//     * @return TechnicalSkill[] Returns an array of TechnicalSkill objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TechnicalSkill
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
