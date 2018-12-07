<?php
namespace App\Controller;

use App\Entity\Event;
use App\Entity\Participation;

use App\Service\EventService;
use App\Form\AddEventFormType;
use App\Form\EventJoinType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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
    public function add( EventService $EventService, Request $request )
    {
        $event = new Event();
        //$event->setCreatedAt(new \DateTime()); //plûtot le mettre ds le constructeur

        $form = $this->createForm(AddEventFormType::class, $event);

        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() ){
            // $em = $this->getDoctrine()->getManager();
            // $em->persist( $event );
            // $em->flush();            
            // On met tout ça dans le service à la place :
            $EventService->add($event); //save de l'event

            return $this->redirectToRoute('event_list');
        }

        return $this->render('event/new.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/event/{id}/join", name="event_join", requirements={"id"="\d+"})
     */
    public function join(Request $request, EventService $EventService, $id)
    {
        $participation = new Participation;
        $form = $this->createForm(EventJoinType::class, $participation);
        // var_dump($request);
        // var_dump($EventService);
        $form->handleRequest($request);

        if ( $form->isValid() ){

            $EventService->join($participation);


        return $this->render('event/join.html.twig', [
            'event' => $EventService->getOne($id)
        ]);
        
    }
 
}

// public function registration(Request $request, ObjectManager $om, UserPasswordEncoderInterface $encoder){

//     $user = new User;
//     $form = $this->createForm(RegistrationType::class, $user);

//     $form->handleRequest($request);

//     if($form->isSubmitted() && $form->isValid()){
//         $hash = $encoder->encodePassword($user, $user->getPassword());//il vérifiera le type d'encodage de User dans le security.yaml, soit bcrypt

//         $user->setPassword($hash);

//         $om->persist($user);
//         $om->flush();

//         return $this->redirectToRoute('security_login');
//     } 
//     return $this->render('security\registration.html.twig',[
//     'form' => $form->createView()
//     ]);
