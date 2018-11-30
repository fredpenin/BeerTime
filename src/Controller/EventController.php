<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
// pour l'utilisation de ll'objet réponse :
use Symfony\Component\HttpFoundation\Response;
// appel de ma classe EventService :
use App\Service\EventService;


class EventController extends AbstractController
{
    private $events;

    /**
     * @Route("/event", name="event_list")
     */
    public function list(EventService $EventService)
    { 
        return $this->render('event/list.html.twig', [
            'events' => $EventService->getAll()
        ]);
    }

    /**
     * @Route("/event/{id}", name="event_show", requirements={"id"="\d+"})
     */
    public function show(EventService $EventService, $id)
    {
        return $this->render('event/show.html.twig', [
            'event' => $EventService->getOne($id)
        ]);
    }

    /**
     * @Route("/event/new", name="add")
     */
    public function add(EventService $EventService)
    {
        return new Response("ajouter un evt");
    }

    /**
     * @Route("/event/{id}/join", name="event_join", requirements={"id"="\d+"})
     */
    public function join(EventService $EventService)
    {
        return new Response("Rejoindre un évenement");
    }
    
}
