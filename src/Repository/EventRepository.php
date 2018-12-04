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
    public function search(?string $name, $sort, $page){
    
        $stmt = $this->createQueryBuilder('e');// e devenant un alias de la table Event
        $stmt->andWhere('e.name LIKE :bind')
            ->setParameter(':bind', '%' . $name . '%');
        if($sort == "price"){
            $stmt->orderBy('e.price', 'ASC');
        }elseif($sort == "date"){
            $stmt->orderBy('e.createdAt', 'DESC');
        }
        //pagination :a
        $nbMaxPerPage = 2;//nb d'events par page
        $firstResult = ($page - 1) * $nbMaxPerPage;
        $stmt->setFirstResult($firstResult)
             ->setMaxResults($nbMaxPerPage);

        return $stmt->getQuery()
            ->getResult();

    }
    //un "statement" (stmt) est une requete qu'on est entrain de préparer; on stoque donc ds une variable plutot que de retourner le résultat tt de suite


    // fonction de comptage des events à venir
    public function countIncoming(){
        return $this->createQueryBuilder('e')
            ->select('count(e)')
            ->andWhere('e.startAt > :bind')
            ->setParameter(':bind', new \DateTime())
            ->getQuery()
            ->getSingleScalarResult();
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
