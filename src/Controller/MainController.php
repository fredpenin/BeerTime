<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="Home")
     */
    public function index()
    {
        // return new Response("Accueil du site");
        $title = "Accueil du site";
        return $this->render('main/index.html.twig', [
            'title' => $title,
        ]);        
    }

}


