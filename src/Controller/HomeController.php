<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {

        return $this->render('home/index.html.twig', []);
        //return new Response('Welcome to your new controller!');
    }
}
