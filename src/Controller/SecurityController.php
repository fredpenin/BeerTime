<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $om, UserPasswordEncoderInterface $encoder){

        $user = new User;
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());//il vérifiera le type d'encodage de User dans le security.yaml, soit bcrypt

            $user->setPassword($hash);

            $om->persist($user);
            $om->flush();

            return $this->redirectToRoute('security_login');
        } 
        return $this->render('security\registration.html.twig',[
        'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(){
        //sait qu'il doit connecter l'utilisateur grace au login_path/check_path qui pointent sur 'security_login' dans security.yaml, 
        //  et fait le lien grace au '_username' et '_password' ds le formulaire
        return $this->render('security/login.html.twig');
    }


    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(){}
}
