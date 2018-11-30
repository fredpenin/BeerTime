<?php
namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Event;


class EventService
{
    // On ne peut pas appeler le use doctrine hors des controlleurs, donc on utilise l'injection de dépendance
    private $om;

    public function __construct(ObjectManager $om){
        $this->om = $om;
    }

    // Recherche de la liste des evenements 
    public function getAll(){
        //old : 
        // $events = $this->events;
        // return $events;
        $repo = $this->om->getRepository(Event::class);          
        return $repo->findAll();
    }

    // Recherche un Event par Id
    public function getOne($id){
        $repo = $this->om->getRepository(Event::class);
        return $repo->find($id);
    }

    // Affiche la liste des évenements pas nom
    public function getByName($name){
        $repo = $this->om->getRepository(Event::class);
        return $repo->findOneByName($name);
    }

}
