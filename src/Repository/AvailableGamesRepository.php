<?php

namespace App\Repository;

use App\Entity\AvailableGames;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AvailableGames|null find($id, $lockMode = null, $lockVersion = null)
 * @method AvailableGames|null findOneBy(array $criteria, array $orderBy = null)
 * @method AvailableGames[]    findAll()
 * @method AvailableGames[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvailableGamesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AvailableGames::class);
    }

    // /**
    //  * @return AvailableGames[] Returns an array of AvailableGames objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AvailableGames
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
