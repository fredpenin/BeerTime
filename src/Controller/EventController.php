<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
// pour l'utilisation de l'objet réponse :
use Symfony\Component\HttpFoundation\Response;
//pour pouvoir faire des requêtes pr le moteur de recherche :
use Symfony\Component\HttpFoundation\Request;
// appel de ma classe EventService :
use App\Service\EventService;
use App\Entity\Event;
// pour paginer la liste des events
use Doctrine\ORM\Tools\Pagination\Paginator;
// accès au Formulaire
use App\Form\AddEventFormType;


class EventController extends AbstractController
{
    private $events;

    /**
     * @Route("/event", name="event_list")
     */ 
    // Liste des events si recherche vide; sinon liste des events correspondant à la recherche
    public function list(Request $request, EventService $EventService)
    { 
        // pour la recherche par prix ou par date (selon que sort=price ou = date)
        $querySort = $request->query->get('sort');
        //pour le moteur de recherche de la navBar
        $querySearch = $request->query->get('querySearch');
        //récup du n° de page pour la pagination
        $queryPage = $request->query->get('page');
        if(empty($queryPage)){
            $queryPage = 1;
        }

        return $this->render('event/list.html.twig', 
            ['events' => $EventService->search($querySearch, $querySort, $queryPage),
            'incomingEvent' => $EventService->countIncoming(),
            'page' => $queryPage
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
     * @Route("/event/new", name="event_add")
     */
    public function add( Request $request )
    {
        $event = new Event();
        $form = $this->createForm(AddEventFormType::class, $event);

        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ){
            $em = $this->getDoctrine()->getManager();
            $em->persist( $event );
            $em->flush();

            return $this->redirectToRoute('event_list');
        }

        return $this->render('event/new.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/event/{id}/join", name="event_join", requirements={"id"="\d+"})
     */
    public function join(EventService $EventService)
    {
        return new Response("Rejoindre un évenement");
    }
 
}
