<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class HomeController extends Controller
{
    /**
     * @Route("/home", name="home")
     */
    public function index(UserInterface $user = null)
    {
        if($user != null)
            return $this->redirectToRoute('goals');

        return $this->render('home/index.html.twig', []);
        //return new Response('Welcome to your new controller!');
    }
}
