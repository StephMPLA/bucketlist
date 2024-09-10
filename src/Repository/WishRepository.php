<?php

namespace App\Repository;

use App\Entity\Wish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Symfony\Component\String\s;

/**
 * @extends ServiceEntityRepository<Wish>
 */
class WishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wish::class);
    }

    public function getWishes()
    {
        //Version QueryBuilder
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder->andWhere('s.isPublished = :isPublished');
            $queryBuilder->setParameter("isPublished", 1);
            $queryBuilder->orderBy('s.dateCreated', 'DESC');


        return $queryBuilder->getQuery()->getResult();
    }
    public function countWishesByCategory()
    {
        $queryBuilder = $this->createQueryBuilder('w')
            ->select('c.name AS categoryName, COUNT(w.id) AS wishCount')
            ->join('w.category', 'c')
            ->groupBy('c.name');

        return $queryBuilder->getQuery()->getResult();
    }
    //    /**
    //     * @return Wish[] Returns an array of Wish objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('w.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Wish
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
