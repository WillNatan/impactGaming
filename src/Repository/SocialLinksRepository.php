<?php

namespace App\Repository;

use App\Entity\SocialLinks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SocialLinks|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocialLinks|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocialLinks[]    findAll()
 * @method SocialLinks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocialLinksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SocialLinks::class);
    }

    // /**
    //  * @return SocialLinks[] Returns an array of SocialLinks objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SocialLinks
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
