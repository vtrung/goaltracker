<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class GoalController extends Controller
{
    /**
     * @Route("/goal", name="goal")
     */
    public function index()
    {

        // replace this line with your own code!
        //return $this->render('@Maker/demoPage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
        return $this->render('goal/index.php');
    }

    /**
     * @Route("/goal/{uid}", name="goalUid")
     */
    public function goalUid($uid)
    {

        $u = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($uid);

        if (!$u) {
            return $this->redirectToRoute("user");
        }
        // replace this line with your own code!
        //return $this->render('@Maker/demoPage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
        return $this->render('goal/index.php', array(
            'user' => $u
        ));
    }

    /**
     * @Route("/goal/{task}/{uid}", name="goalUid")
     */
    public function task(){

    }

}
