<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user")
     */
    public function index(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('username', TextType::class)
            ->add('validate', SubmitType::class, array('label' => 'Login'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            $name = $form->getData('username');

            $u = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(['username' => $name]);

            if (!$u) {
                throw $this->createNotFoundException(
                    'No user found for username: ' . $name
                );
            }

            return $this->redirectToRoute('goal');
            //return $this->render('@Maker/demoPage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
        }
        // replace this line with your own code!
        return $this->render('user/index.php', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/user/create", name="create")
     */
    public function create(Request $request)
    {


        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class)
            ->add('fname', TextType::class)
            ->add('lname', TextType::class)
            ->add('email', TextType::class)
            ->add('dob', DateType::class)
            ->add('save', SubmitType::class, array('label' => 'Create User'))
            ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user= $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $em = $this->getDoctrine()->getManager();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            //return $this->redirectToRoute('/');
            return $this->render('@Maker/demoPage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
        }

        return $this->render("User/create.php", array(
            'form' => $form->createView(),
        ));
    }
}
