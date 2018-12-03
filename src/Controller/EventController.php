<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
// pour l'utilisation de ll'objet réponse :
use Symfony\Component\HttpFoundation\Response;
//pour pouvoir faire des requêtes pr le moteur de recherche :
use Symfony\Component\HttpFoundation\Request;

// appel de ma classe EventService :
use App\Service\EventService;

use App\Entity\Event;
// pour paginer la liste des events
use Doctrine\ORM\Tools\Pagination\Paginator;

class EventController extends AbstractController
{
    private $events;

    /**
     * @Route("/event", name="event_list")
     */ 
    // Liste des events si recherche vide; sinon liste des events correspondant à la recherche
    public function list(Request $request, EventService $EventService)
    { 
        $querySort = $request->query->get('sort');
        $querySearch = $request->query->get('querySearch');
        return $this->render('event/list.html.twig', 
            ['events' => $EventService->search($querySearch, $querySort),
            'incomingEvent' => $EventService->countIncoming()
            ]
        );
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
