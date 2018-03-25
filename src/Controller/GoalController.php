<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\User;
use App\Entity\Goal;
use App\Entity\Task;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class GoalController extends Controller
{
    /**
     * @Route("/goal", name="goals")
     */
    public function index(UserInterface $user = null)
    {
        if($user == null)
            return $this->redirectToRoute(login);

        $uid = $user->getId();
        $repo = $this->getDoctrine()->getRepository(Goal::class);
        $goals = $repo->findBy(['uid'=>$uid]);

        return $this->render('goal/index.html.twig', ["username"=>$user->getUsername(), "goals"=>$goals]);
    }

    /**
     * @Route("/goal/info", name="goal")
     */
    public function goal(Request $request, UserInterface $user = null)
    {

        $gid = $request->query->get("gid");
        $goal = $this->getDoctrine()->getRepository(Goal::class)->findOneBy(["id" => $gid]);
        $tasks = $this->getDoctrine()->getRepository(Task::class)->findBy(["gid" => $gid]);

        if($gid == null){
            //var_dump($gid);
            return $this->redirectToRoute("goals");
        } else {
            $data = array(
                "username"=>$user->getUsername(),
                "goal" => $goal,
                "tasks" => $tasks
            );
            return $this->render('goal/goal.html.twig', $data);
        }
    }

    /**
     * @Route("/goal/create", name="creategoal")
     */
    public function creategoal(Request $request, UserInterface $user = null)
    {

        $uid = $user->getId();
        $goal = new Goal();

        $form = $this->createFormBuilder($goal)
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('goaldate', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Goal'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $goal = $form->getData();
            $goal->setUid($uid);
            $goal->setStatus("new");

            $em = $this->getDoctrine()->getManager();
            $em->persist($goal);
            $em->flush();

            return $this->redirectToRoute('goals');
        }

        return $this->render("goal/creategoal.html.twig", array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/goal/createtask", name="createtask")
     */
    public function createtask(Request $request, UserInterface $user = null)
    {
        $uid = $user->getId();
        $gid = $request->query->get("gid");

        $task = new Task();

        $form = $this->createFormBuilder($task)
            ->add('description', TextType::class)
            ->add('goaldate', DateType::class)
            ->add('completedate', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            $task = $form->getData();
            $task->setGid($gid);
            $task->setStatus("new");

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('goal', array('gid'=>$task->getGid()));
        }

        return $this->render("goal/createtask.html.twig", array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/goal/edit", name="editgoal")
     */
    public function editgoal(Request $request, UserInterface $user = null)
    {

        $uid = $user->getId();
        $goal = new Goal();

        $form = $this->createFormBuilder($goal)
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('goaldate', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Goal'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $goal = $form->getData();
            $goal->setUid($uid);
            $goal->setStatus("new");

            $em = $this->getDoctrine()->getManager();
            $em->persist($goal);
            $em->flush();

            return $this->redirectToRoute('goals');
        }

        return $this->render("goal/creategoal.html.twig", array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/goal/edittask", name="edittask")
     */
    public function edittask(Request $request, UserInterface $user = null)
    {
        $uid = $user->getId();
        $gid = $request->query->get("gid");
        $tid = $request->query->get("tid");

        $task = $this->getDoctrine()->getRepository(Task::class)->findOneBy(["id" => $tid]);

        $form = $this->createFormBuilder($task)
            ->add('description', TextType::class, array('value' => $task->getDescription()))
            ->add('goaldate', DateType::class, array('value' => $task->getGoalDate()))
            ->add('completedate', DateType::class, array('value' => $task->getCompleteDate()))
            ->add('save', SubmitType::class, array('label' => 'Edit Task'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $task->setDescription($data->description);
            $task->setGoalDate($data->goaldate);
            $task->setCompleteDate($data->completedate);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('goal', array('gid'=>$task->getGid()));
        }

        return $this->render("goal/createtask.html.twig", array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/goal/deletetask", name="deletetask")
     */
    public function deletetask(Request $request, UserInterface $user = null)
    {
        $uid = $user->getId();
        $gid = $request->query->get("gid");
        $tid = $request->query->get("tid");

        $task = $this->getDoctrine()->getRepository(Task::class)->findOneBy(["id" => $tid]);

        if($task != null){
            $gid = $task->getGid();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($task);
            $entityManager->flush();

        }

        return $this->redirectToRoute('goal', array('gid'=>$gid));
    }

    /**
     * @Route("/goal/deletegoal", name="deletegoal")
     */
    public function deletegoal(Request $request, UserInterface $user = null)
    {
        $uid = $user->getId();
        $gid = $request->query->get("gid");

        $goal = $this->getDoctrine()->getRepository(Goal::class)->findOneBy(["id" => $gid]);

        if($goal != null){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($goal);
            $entityManager->flush();

        }
        return $this->redirectToRoute('goals');
    }



}
