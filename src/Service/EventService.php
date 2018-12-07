<?php
namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Event;
use App\Entity\User;


class EventService
{
    // On ne peut pas appeler le use doctrine hors des controlleurs, donc on utilise l'injection de dépendance
    private $om;

    public function __construct(ObjectManager $om){ // revient à faire un $this->getDoctrine()->getManager(); dans un contrôleur
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

    // Recherche des évenements par nom et par tri (date ou nom)
    public function search($name, $sort, $page){//$page reçoit le $queryPage
        $repo = $this->om->getRepository(Event::class);
        return $repo->search($name, $sort, $page);
    }

    // Recherche du nombre d'évenements à venir
    public function countIncoming(){
        $repo = $this->om->getRepository(Event::class);
        return $repo->countIncoming();
    }

    // Création d'un évenement
    public function add($event){
        $repo = $this->om->getRepository(User::class);
        $user = $repo->find(1);
        $event->setOwner($user);

        $this->setupMedia( $event );

        $this->om->persist( $event );
        $this->om->flush();
    }


    private function setupMedia($event){
        if(!empty($event->getPosterUrl())){
            $event->setPoster($event->getPosterUrl());
        }

        $file = $event->getPosterFile();
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        $file->move('./data', $fileName);

        return $event->setPoster('data/' . $fileName);
    }

    //rejoindre un event
    private function join($participation){
        $eventRepo = $this->om->getRepository(Event::class);
        $userRepo = $this->om->getRepository(User::class);
        
    }

}
