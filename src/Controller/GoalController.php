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

        // replace this line with your own code!
        //return $this->render('@Maker/demoPage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
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
            ->add('save', SubmitType::class, array('label' => 'Create User'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $goal = $form->getData();
            $goal->setUid($uid);
            $goal->setStatus("new");

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $em = $this->getDoctrine()->getManager();
            $em = $this->getDoctrine()->getManager();
            $em->persist($goal);
            $em->flush();

            return $this->redirectToRoute('goals');
            //return $this->render('@Maker/demoPage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
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
        $gid = $gid = $request->query->get("gid");
        $task = new Task();

        $form = $this->createFormBuilder($task)
            ->add('description', TextType::class)
            ->add('goaldate', DateType::class)
            ->add('completedate', DateType::class)
            ->add('gid',HiddenType::class, array('data'=>$gid))
            ->add('save', SubmitType::class, array('label' => 'Create User'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();
            $task->setStatus("new");

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $em = $this->getDoctrine()->getManager();
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('goals');
            //return $this->render('@Maker/demoPage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
        }

        return $this->render("goal/createtask.html.twig", array(
            'form' => $form->createView(),
        ));
    }

//    /**
//     * @Route("/goal/deletetask", name="deletetask")
//     */
//    public function deletetask(Request $request, UserInterface $user = null)
//    {
//        $uid = $user->getId();
//        $gid = $gid = $request->query->get("gid");
//        $task = new Task();
//
//        $form = $this->createFormBuilder($task)
//            ->add('description', TextType::class)
//            ->add('goaldate', DateType::class)
//            ->add('completedate', DateType::class)
//            ->add('gid',HiddenType::class, array('data'=>$gid))
//            ->add('save', SubmitType::class, array('label' => 'Create User'))
//            ->getForm();
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            // $form->getData() holds the submitted values
//            // but, the original `$task` variable has also been updated
//            $task = $form->getData();
//            $task->setStatus("new");
//
//            // ... perform some action, such as saving the task to the database
//            // for example, if Task is a Doctrine entity, save it!
//            // $em = $this->getDoctrine()->getManager();
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($task);
//            $em->flush();
//
//            return $this->redirectToRoute('goals');
//            //return $this->render('@Maker/demoPage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
//        }
//
//        return $this->render("goal/createtask.html.twig", array(
//            'form' => $form->createView(),
//        ));
//    }



}
