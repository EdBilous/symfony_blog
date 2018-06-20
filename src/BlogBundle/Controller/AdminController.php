<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12.06.18
 * Time: 23:36
 */

namespace BlogBundle\Controller;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
//use AppBundle\AppBundle;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{

    /**
     *
     * @Route("/admin", name="admin_index_route")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('admin_login_route');
    }

    /**
     *
     * @Route("/admin/login.html", name="admin_login_route")
     */
    public function loginAction()
    {
        return $this->render('@Blog/admin/login.html.twig');
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

        return $this->render('@Blog/admin/register.html.twig',
            ['form' => $form->createView()]);
    }
}
