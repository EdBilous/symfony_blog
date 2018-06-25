<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     *
     * @Route("/admin/login.html", name="admin_login_route")
     */
    public function loginAction()
    {
        return $this->render('default/login.html.twig');
    }

    /**
     *
     * @Route("/admin/register.html", name="admin_register_route")
     */
    public function registerAction(Request $request)
    {
        // создаем форму
        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserType', $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('blog_index_route');
        }

        return $this->render('default/register.html.twig',
            ['form' => $form->createView()]);
    }
}