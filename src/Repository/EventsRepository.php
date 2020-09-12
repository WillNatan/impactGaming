<?php

namespace App\Repository;

use App\Entity\Events;
use App\Entity\SearchEvent;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\Cast\Array_;

/**
 * @method Events|null find($id, $lockMode = null, $lockVersion = null)
 * @method Events|null findOneBy(array $criteria, array $orderBy = null)
 * @method Events[]    findAll()
 * @method Events[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Events::class);
    }

    public function findAllEvents()
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->orderBy('e.launchDate', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllEventsQuery()
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            
        ;
    }

    public function findByUser($user)
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.user = :user')
            ->setParameter('user',$user)
            ->orderBy('e.launchDate', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function SearchByUser($user)
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.user = :user')
            ->setParameter('user',$user)
            
        ;
    }

    public function findByAllQueries(SearchEvent $searchEvent)
    {
        $query = $this->findAllEventsQuery();
        if($searchEvent->getCategory()){
            $query
            ->andWhere('e.category = :category')
            ->setParameter('category', $searchEvent->getCategory())
            ;
        }
        
        if($searchEvent->getGame()){
            $query
                ->innerJoin('e.availableGames', 'g')
                ->andWhere('g.id = :game')
                ->setParameter('game',$searchEvent->getGame());
        }
        if($searchEvent->getPrice())
        {
            if($searchEvent->getPrice() == 'cashprize-up'){
                $query
                    ->addOrderBy('e.cashprize','ASC');
            }
            else if($searchEvent->getPrice() == 'cashprize-down'){
                $query
                    ->addOrderBy('e.cashprize','DESC');
            }
            else if($searchEvent->getPrice() == 'price-down'){
                $query
                    ->addOrderBy('e.price','DESC');
            }
            else if($searchEvent->getPrice() == 'price-up'){
                $query
                    ->addOrderBy('e.price','ASC');
            }
        }
        if($searchEvent->getSupport())
        {
            $query
                ->innerJoin('e.support','s')
                ->andWhere('s = :support')
                ->setParameter('support',$searchEvent->getSupport());
        }
        if($searchEvent->getDepartment())
        {
            $query
                ->innerJoin('e.department','d')
                ->andWhere('d = :department')
                ->setParameter('department',$searchEvent->getDepartment());
        }
        return $query->getQuery();
    }


    public function findByAllQueriesByUser(SearchEvent $searchEvent, User $user)
    {
        $query = $this->SearchByUser($user);
        if($searchEvent->getCategory()){
            $query
            ->andWhere('e.category = :category')
            ->setParameter('category', $searchEvent->getCategory())
            ;
        }
        
        if($searchEvent->getGame()){
            $query
                ->innerJoin('e.availableGames', 'g')
                ->andWhere('g.id = :game')
                ->setParameter('game',$searchEvent->getGame());
        }
        if($searchEvent->getPrice())
        {
            if($searchEvent->getPrice() == 'cashprize-up'){
                $query
                    ->addOrderBy('e.cashprize','ASC');
            }
            else if($searchEvent->getPrice() == 'cashprize-down'){
                $query
                    ->addOrderBy('e.cashprize','DESC');
            }
            else if($searchEvent->getPrice() == 'price-down'){
                $query
                    ->addOrderBy('e.price','DESC');
            }
            else if($searchEvent->getPrice() == 'price-up'){
                $query
                    ->addOrderBy('e.price','ASC');
            }
        }
        if($searchEvent->getSupport())
        {
            $query
                ->innerJoin('e.support','s')
                ->andWhere('s = :support')
                ->setParameter('support',$searchEvent->getSupport());
        }
        if($searchEvent->getDepartment())
        {
            $query
                ->innerJoin('e.department','d')
                ->andWhere('d = :department')
                ->setParameter('department',$searchEvent->getDepartment());
        }
        return $query->getQuery();
    }
    // /**
    //  * @return Events[] Returns an array of Events objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Events
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
