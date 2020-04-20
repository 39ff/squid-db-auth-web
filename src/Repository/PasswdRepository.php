<?php

namespace App\Repository;

use App\Entity\Passwd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Passwd|null find($id, $lockMode = null, $lockVersion = null)
 * @method Passwd|null findOneBy(array $criteria, array $orderBy = null)
 * @method Passwd[]    findAll()
 * @method Passwd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PasswdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Passwd::class);
    }

    // /**
    //  * @return Passwd[] Returns an array of Passwd objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Passwd
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
