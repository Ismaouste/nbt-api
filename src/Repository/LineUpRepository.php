<?php

namespace App\Repository;

use App\Entity\LineUp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LineUp|null find($id, $lockMode = null, $lockVersion = null)
 * @method LineUp|null findOneBy(array $criteria, array $orderBy = null)
 * @method LineUp[]    findAll()
 * @method LineUp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LineUpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LineUp::class);
    }

    // /**
    //  * @return LineUp[] Returns an array of LineUp objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LineUp
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
