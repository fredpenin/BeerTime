<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class EventController extends AbstractController
{
    /**
     * @Route("/event", name="event_list")
     */
    public function list(  )
    {
        // return new Response("liste des évenements");

        $title = "Liste des Events";
        return $this->render('event/list.html.twig', [
            'title' => $title,
        ]);
    }

    /**
     * @Route("/event/{id}", name="event_show", requirements={"id"="\d+"})
     */
    public function show( $id )
    {
        // return new Response("un évenement");
        $title = "Evenement";
        return $this->render('event/single.html.twig', [
            'title' => $title,
        ]);
    }

    /**
     * @Route("/event/new", name="add")
     */
    public function add(  )
    {
        return new Response("ajouter un evt");
    }

    /**
     * @Route("/event/{id}/join", name="event_join", requirements={"id"="\d+"})
     */
    public function join( $id )
    {
        return new Response("Rejoindre un évenement");
    }
    
}
