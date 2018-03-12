<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use App\Entity\Goal;
use App\Entity\Task;

class ApiController extends Controller
{
    /**
     * @Route("/api", name="api")
     */
    public function index(UserInterface $user = null){
        if($user == null)
            return new Response("unauthorized");
        return new Response("success");
    }

    /**
     * @Route("/api/goals", name="apigoals")
     */
    public function getGoals(UserInterface $user = null){
        if($user == null)
            return new Response("unauthorized");

        $id = $user->getId();
        $repo = $this->getDoctrine()->getRepository(Goal::class);
        $goals = $repo->findBy(["uid"=>$id]);
        return $this->json($goals);
    }

    /**
     * @Route("/api/tasks", name="apitasks")
     */
    public function getTasks(Request $request, UserInterface $user = null){
        if($user == null)
            return new Response("unauthorized");

        $id = $request->query->get('gid');
        $repo = $this->getDoctrine()->getRepository(Task::class);
        $tasks = $repo->findBy(["gid"=>$id]);
        return $this->json($tasks);
    }


}