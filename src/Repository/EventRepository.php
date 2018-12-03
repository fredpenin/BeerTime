<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    // fonction de recherche par nom. Placée ici plutôt que dans le service afin qu'elle soit réutilisable dans plusieurs services
    public function search(?string $name){
        return $this->createQueryBuilder('e')// e devenant un alias de la table Event
            ->andWhere('e.name LIKE :bind')
            ->setParameter(':bind', '%' . $name . '%')
            ->getQuery()
            ->getResult();
    }

    // fonction de comptage des events à venir
    public function countIncoming(){
        return $this->createQueryBuilder('e')
            ->select('count(e)')
            ->andWhere('e.startAt > :bind')
            ->setParameter(':bind', new \DateTime())
            ->getQuery()
            ->getSingleScalarResult();
    }

    // fonction de tri par nom
    public function sortByName(){
        return $this->createQueryBuilder('e')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // fonction de tri par date
    public function sortByDate(){
        return $this->createQueryBuilder('e')
            ->orderBy('e.startAt', 'ASC')
            ->getQuery()
            ->getResult();
    }


    // /**
    //  * @return Event[] Returns an array of Event objects
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
    public function findOneBySomeField($value): ?Event
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
