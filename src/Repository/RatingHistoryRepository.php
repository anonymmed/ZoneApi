<?php

namespace App\Repository;

use App\Entity\RatingHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RatingHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method RatingHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method RatingHistory[]    findAll()
 * @method RatingHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RatingHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RatingHistory::class);
    }

    // /**
    //  * @return RatingHistory[] Returns an array of RatingHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RatingHistory
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
